<?php

namespace lenz\contentfield\models\values;

use Craft;
use craft\helpers\Template;
use craft\helpers\UrlHelper;
use craft\web\Application as WebApplication;
use craft\web\Response;
use Exception;
use lenz\contentfield\behaviors\InstanceSiblingsBehavior;
use lenz\contentfield\events\BeforeActionEvent;
use lenz\contentfield\helpers\BeforeActionInterface;
use lenz\contentfield\helpers\InstanceAwareInterface;
use lenz\contentfield\helpers\ReferenceMap;
use lenz\contentfield\models\fields\AbstractField;
use lenz\contentfield\models\fields\InstanceField;
use lenz\contentfield\models\schemas\AbstractSchema;
use lenz\contentfield\Plugin;
use lenz\contentfield\twig\DisplayInterface;
use Throwable;
use Twig\Markup;
use yii\base\Model;

/**
 * Class InstanceValue
 *
 * @property InstanceField|null $_field
 *
 * InstanceSiblingsBehavior
 * @method InstanceValue|null getNextSibling()
 * @method InstanceValue|null getParentInstance()
 * @method InstanceValue|null getPreviousSibling()
 * @method boolean hasNextSibling($qualifier = null)
 * @method boolean hasParentInstance($qualifier = null)
 * @method boolean hasPreviousSibling($qualifier = null)
 */
class InstanceValue
  extends Model
  implements
    BeforeActionInterface,
    DisplayInterface,
    ReferenceMapValueInterface,
    TraversableValueInterface,
    ValueInterface
{
  use ValueTrait;

  /**
   * @var Model|null
   */
  private $_model;

  /**
   * @var string
   */
  private $_output;

  /**
   * @var string
   */
  private $_originalUuid = null;

  /**
   * @var AbstractSchema
   */
  private $_schema;

  /**
   * @var string
   */
  private $_uuid;

  /**
   * @var array
   */
  private $_values = [];

  /**
   * @var bool
   */
  private $_visible = true;

  /**
   * @var string
   */
  const ERRORS_PROPERTY = '__errors';
  const ORIGINAL_UUID_PROPERTY = '__originalUuid';
  const TYPE_PROPERTY = '__type';
  const UUID_PROPERTY = '__uuid';
  const VISIBLE_PROPERTY = '__visible';


  /**
   * TypedModel constructor.
   *
   * @param array $data
   * @param AbstractSchema $schema
   * @param ValueInterface|null $parent
   * @param InstanceField|null $field
   * @throws Exception
   */
  public function __construct(array $data, AbstractSchema $schema, ValueInterface $parent = null, InstanceField $field = null) {
    parent::__construct();

    $this->_field = $field;
    $this->_parent = $parent;
    $this->_schema = $schema;

    if (array_key_exists(self::UUID_PROPERTY, $data)) {
      $this->_uuid = $data[self::UUID_PROPERTY];
    } else {
      $this->_uuid = self::uuid();
    }

    if (array_key_exists(self::ORIGINAL_UUID_PROPERTY, $data)) {
      $this->_originalUuid = $data[self::ORIGINAL_UUID_PROPERTY];
    }

    if (array_key_exists(self::VISIBLE_PROPERTY, $data)) {
      $this->_visible = !!$data[self::VISIBLE_PROPERTY];
    }

    foreach ($this->_schema->fields as $name => $field) {
      $this->$name = array_key_exists($name, $data) ? $data[$name] : null;
    }
  }

  /**
   * @inheritdoc
   */
  public function __get($name) {
    if (
      substr($name, 0, 4) == 'raw:' &&
      array_key_exists(substr($name, 4), $this->_schema->fields)
    ) {
      return $this->_values[substr($name, 4)]->getEditorData();
    } elseif (array_key_exists($name, $this->_schema->fields)) {
      return $this->_values[$name];
    } elseif ($this->_schema->hasConstant($name)) {
      return $this->_schema->getConstant($name);
    } else {
      return parent::__get($name);
    }
  }

  /**
   * @inheritdoc
   * @throws Exception
   */
  public function __set($name, $value) {
    if (array_key_exists($name, $this->_schema->fields)) {
      $this->_values[$name] = $this->_schema->fields[$name]->createValue($value, $this);
    } else {
      parent::__set($name, $value);
    }
  }

  /**
   * @inheritdoc
   */
  public function __isset($name) {
    if (array_key_exists($name, $this->_schema->fields)) {
      return true;
    } elseif ($this->_schema->hasConstant($name)) {
      return true;
    } else {
      return parent::__isset($name);
    }
  }

  /**
   * @inheritdoc
   * @throws Exception
   */
  public function __toString() {
    return $this->render();
  }

  /**
   * @inheritDoc
   */
  public function addError($attribute, $error = '') {
    if (substr($attribute, 0, 4) == 'raw:') {
      $attribute = substr($attribute, 4);
    }

    parent::addError($attribute, $error);
  }

  /**
   * @inheritDoc
   */
  public function attributeLabels() {
    return array_map(function(AbstractField $field) {
      return Plugin::t($field->label);
    }, $this->_schema->fields);
  }

  /**
   * @inheritdoc
   */
  public function attributes() {
    return array_keys($this->_schema->fields);
  }

  /**
   * @inheritDoc
   */
  public function behaviors() {
    return [
      InstanceSiblingsBehavior::class
    ];
  }

  /**
   * @inheritDoc
   * @throws Exception
   */
  public function display(array $variables = []) {
    if ($this->isVisible()) {
      if (isset($this->_output)) {
        echo $this->_output;
      } else {
        $this->_schema->display($this, $variables);
      }
    }
  }

  /**
   * @inheritDoc
   */
  public function findUuid(string $uuid) {
    if ($this->_uuid == $uuid) {
      return $this;
    }

    foreach ($this->_values as $value) {
      if ($value instanceof TraversableValueInterface) {
        $result = $value->findUuid($uuid);
        if (!is_null($result)) {
          return $result;
        }
      }
    }

    return null;
  }

  /**
   * @param string|string[] $qualifier
   * @return InstanceValue[]
   * @throws Throwable
   */
  public function findInstances($qualifier) {
    $result = array();
    if ($this->_schema->matchesQualifier($qualifier)) {
      $result[] = $this;
    }

    foreach ($this->_values as $value) {
      if ($value instanceof TraversableValueInterface) {
        $matches = $value->findInstances($qualifier);
        if (count($matches) > 0) {
          $result = array_merge($result, $matches);
        }
      }
    }

    return $result;
  }

  /**
   * @inheritDoc
   */
  public function getAttributeLabel($attribute) {
    if (substr($attribute, 0, 4) == 'raw:') {
      $attribute = substr($attribute, 4);
    }

    return parent::getAttributeLabel($attribute);
  }

  /**
   * @return string|null
   */
  public function getCachedOutput() {
    return isset($this->_output)
      ? $this->_output
      : null;
  }

  /**
   * @return string|null
   */
  public function getChunkUrl() {
    $element = $this->getElement();
    if (is_null($element)) {
      return null;
    }

    $url = $element->getUrl();
    if (is_null($url)) {
      return null;
    }

    return UrlHelper::urlWithParams($url, [
      Plugin::$UUID_PARAM => $this->_uuid,
    ]);
  }

  /**
   * @return Markup|string
   */
  public function getEditAttributes() {
    return Plugin::$IS_ELEMENT_PREVIEW
      ? Template::raw(' data-contentfield-edit-uuid="' . $this->_uuid . '" ')
      : '';
  }

  /**
   * @inheritDoc
   */
  public function getEditorValue() {
    $result = array(
      self::ERRORS_PROPERTY        => $this->getErrors(),
      self::ORIGINAL_UUID_PROPERTY => $this->_originalUuid,
      self::TYPE_PROPERTY          => $this->_schema->qualifier,
      self::UUID_PROPERTY          => $this->_uuid,
      self::VISIBLE_PROPERTY       => $this->_visible,
    );

    foreach ($this->_schema->fields as $name => $field) {
      $result[$name] = $field->getEditorValue($this->_values[$name]);
    }

    return $result;
  }

  /**
   * @inheritdoc
   * @throws Exception
   */
  public function getHtml(array $variables = []) {
    return new Markup($this->render($variables), 'utf-8');
  }

  /**
   * @return Model|null
   * @throws Exception
   */
  public function getModel() {
    if (!isset($this->_model)) {
      $schema     = $this->_schema;
      $modelClass = $schema->model;
      $model      = null;

      if (!empty($modelClass)) {
        $model = new $modelClass();

        if (!($model instanceof Model)) {
          throw new Exception('Invalid model class ' . $modelClass);
        }

        if ($model instanceof InstanceAwareInterface) {
          $model->setInstance($this);
        }
      }

      $this->_model = $model;
    }

    return $this->_model;
  }

  /**
   * @return string|null
   */
  public function getOriginalUuid() {
    return $this->_originalUuid;
  }

  /**
   * @inheritdoc
   */
  public function getReferenceMap(ReferenceMap $map = null) {
    if (is_null($map)) {
      $map = new ReferenceMap();
    }

    foreach ($this->_values as $value) {
      if ($value instanceof ReferenceMapValueInterface) {
        $value->getReferenceMap($map);
      }
    }

    return $map;
  }

  /**
   * @return AbstractSchema
   */
  public function getSchema() {
    return $this->_schema;
  }

  /**
   * @inheritDoc
   */
  public function getSearchKeywords() {
    return implode(' ', array_map(function(AbstractField $field) {
      return $field->getSearchKeywords($this->_values[$field->name]);
    }, $this->_schema->fields));
  }

  /**
   * @inheritDoc
   */
  public function getSerializedValue() {
    $result = array(
      self::ORIGINAL_UUID_PROPERTY => $this->_originalUuid,
      self::TYPE_PROPERTY          => $this->_schema->qualifier,
      self::UUID_PROPERTY          => $this->_uuid,
      self::VISIBLE_PROPERTY       => $this->_visible,
    );

    foreach ($this->_schema->fields as $name => $field) {
      $result[$name] = $field->getSerializedValue($this->_values[$name]);
    }

    return $result;
  }

  /**
   * @return string
   */
  public function getUuid() {
    return $this->_uuid;
  }

  /**
   * @param string $name
   * @return mixed|null
   */
  public function getValue(string $name) {
    return array_key_exists($name, $this->_values)
      ? $this->_values[$name]
      : null;
  }

  /**
   * @return mixed[]
   */
  public function getValues() {
    return $this->_values;
  }

  /**
   * @return bool
   */
  public function hasCachedOutput() {
    return isset($this->_output);
  }

  /**
   * @inheritDoc
   */
  public function isEmpty() {
    return false;
  }

  /**
   * @return bool
   */
  public function isVisible() {
    return $this->_visible;
  }

  /**
   * @inheritDoc
   * @throws Exception
   */
  public function onBeforeAction(BeforeActionEvent $event) {
    $model = $this->getModel();
    if (!is_null($model) && $model instanceof BeforeActionInterface) {
      $model->onBeforeAction($event);
    }

    foreach ($this->_values as $value) {
      if ($value instanceof BeforeActionInterface) {
        $value->onBeforeAction($event);
      }
    }

    if (
      $event->requestedUuid == $this->_uuid &&
      Craft::$app instanceof WebApplication
    ) {
      $event->originalEvent->isValid = false;
      $response = Craft::$app->response;
      $content = $this->render([
        'isChunkRequest' => true
      ]);

      if (Craft::$app->getRequest()->getAcceptsJson()) {
        $response->format = Response::FORMAT_JSON;
        $response->data = [
          'success' => true,
          'uuid'    => $this->_uuid,
          'content' => $content,
        ];
      } else {
        $response->data = $content;
      }
    }
  }

  /**
   * @param array $variables
   * @param array $options
   * @return string
   * @throws Exception
   */
  public function render(array $variables = [], array $options = []) {
    if (!$this->isVisible()) {
      return '';
    }

    if (isset($this->_output)) {
      return $this->_output;
    }

    return $this->_schema->render($this, $variables, $options);
  }

  /**
   * @inheritDoc
   */
  public function rules() {
    return $this->_schema->getValueRules();
  }

  /**
   * @param string $value
   */
  public function setCachedOutput($value) {
    $this->_output = $value;
  }


  // Static methods
  // --------------

  /**
   * @return string
   * @throws Exception
   */
  static function uuid() {
    $data = random_bytes(16);
    $data[6] = chr(ord($data[6]) & 0x0f | 0x40); // set version to 0100
    $data[8] = chr(ord($data[8]) & 0x3f | 0x80); // set bits 6-7 to 10

    return vsprintf('%s%s-%s-%s-%s-%s%s%s', str_split(bin2hex($data), 4));
  }
}
