<?php

namespace lenz\contentfield\models\values;

use Craft;
use craft\helpers\Template;
use craft\helpers\UrlHelper;
use craft\web\Response;
use Exception;
use lenz\contentfield\events\BeforeActionEvent;
use lenz\contentfield\models\BeforeActionInterface;
use lenz\contentfield\models\fields\AbstractField;
use lenz\contentfield\models\fields\InstanceField;
use lenz\contentfield\models\InstanceAwareInterface;
use lenz\contentfield\models\ReferenceMapValueInterface;
use lenz\contentfield\models\schemas\AbstractSchema;
use lenz\contentfield\models\schemas\TemplateSchema;
use lenz\contentfield\models\TraversableValueInterface;
use lenz\contentfield\Plugin;
use lenz\contentfield\utilities\ReferenceMap;
use lenz\contentfield\utilities\twig\DisplayInterface;
use Twig\Markup;
use yii\base\Model;

/**
 * Class InstanceValue
 *
 * @property InstanceField|null $_field
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
   * @var string
   */
  const ERRORS_PROPERTY = '__errors';
  const ORIGINAL_UUID_PROPERTY = '__originalUuid';
  const TYPE_PROPERTY = '__type';
  const UUID_PROPERTY = '__uuid';


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
      unset($data[self::UUID_PROPERTY]);
    } else {
      $this->_uuid = self::uuid();
    }

    if (array_key_exists(self::ORIGINAL_UUID_PROPERTY, $data)) {
      $this->_originalUuid = $data[self::ORIGINAL_UUID_PROPERTY];
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
   * @throws Exception
   */
  public function display(array $variables = []) {
    if (isset($this->_output)) {
      echo $this->_output;
    }

    $this->normalizeVariables($variables);
    $this->_schema->display($this, $variables);
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
   * @inheritDoc
   */
  public function getEditorValue() {
    $result = array(
      self::ERRORS_PROPERTY        => $this->getErrors(),
      self::ORIGINAL_UUID_PROPERTY => $this->_originalUuid,
      self::TYPE_PROPERTY          => $this->_schema->qualifier,
      self::UUID_PROPERTY          => $this->_uuid,
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
      $modelClass = $schema instanceof TemplateSchema ? $schema->model : null;
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
   * @return InstanceValue|null
   */
  public function getNextSibling() {
    return $this->getSibling(1);
  }

  /**
   * @return string|null
   */
  public function getOriginalUuid() {
    return $this->_originalUuid;
  }

  /**
   * @return InstanceValue|null
   */
  public function getParentInstance() {
    $parent = $this->_parent;
    if ($parent instanceof ArrayValue) {
      $parent = $parent->getParent();
    }

    return $parent instanceof InstanceValue ? $parent : null;
  }

  /**
   * @return InstanceValue|null
   */
  public function getPreviousSibling() {
    return $this->getSibling(-1);
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
    );

    foreach ($this->_schema->fields as $name => $field) {
      $result[$name] = $field->getSerializedValue($this->_values[$name]);
    }

    return $result;
  }

  /**
   * @return string
   */
  public function getType() {
    return $this->_schema->qualifier;
  }

  /**
   * @return string
   */
  public function getUuid() {
    return $this->_uuid;
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
   * @param string|string[]|null $qualifier
   * @return boolean
   */
  public function hasNextSibling($qualifier = null) {
    return $this->isInstanceWithQualifier($this->getSibling(1), $qualifier);
  }

  /**
   * @param string|string[]|null $qualifier
   * @return bool
   */
  public function hasParentInstance($qualifier = null) {
    return $this->isInstanceWithQualifier($this->getParentInstance(), $qualifier);
  }

  /**
   * @param string|string[]|null $qualifier
   * @return boolean
   */
  public function hasPreviousSibling($qualifier = null) {
    return $this->isInstanceWithQualifier($this->getSibling(-1), $qualifier);
  }

  /**
   * @inheritDoc
   */
  public function isEmpty() {
    return false;
  }

  /**
   * @param string|string[] $qualifier
   * @return bool
   */
  public function isOfType($qualifier) {
    return $this->_schema->matchesQualifier($qualifier);
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

    if ($event->requestedUuid == $this->_uuid) {
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
    if (isset($this->_output)) {
      return $this->_output;
    }

    $this->normalizeVariables($variables);
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


  // Private methods
  // ---------------

  /**
   * @return Markup
   */
  private function getEditAttributes() {
    return Template::raw(' data-contentfield-edit-uuid="' . $this->_uuid . '" ');
  }

  /**
   * @param int $offset
   * @return InstanceValue|null
   */
  private function getSibling($offset) {
    $parent = $this->_parent;
    if (is_null($this->_parent) || !($parent instanceof ArrayValue)) {
      return null;
    }

    for ($index = 0; $index < count($parent); $index++) {
      if ($parent->offsetGet($index) == $this) {
        return $parent->offsetExists($index + $offset)
          ? $parent->offsetGet($index + $offset)
          : null;
      }
    }

    return null;
  }

  /**
   * @param mixed $value
   * @param string|string[]|null $qualifier
   * @return bool
   */
  private function isInstanceWithQualifier($value, $qualifier = null) {
    if (!($value instanceof InstanceValue)) {
      return false;
    }

    return is_null($qualifier)
      ? true
      : $value->_schema->matchesQualifier($qualifier);
  }

  /**
   * @param array $variables
   * @throws Exception
   */
  private function normalizeVariables(array &$variables) {
    $variables += [
      'isChunkRequest' => false,
      'model'          => $this->getModel(),
      'editAttributes' => Plugin::$IS_ELEMENT_PREVIEW
        ? $this->getEditAttributes()
        : '',
    ];

    if (!array_key_exists('loop', $variables)) {
      $variables['loop'] = [
        'index'     => 1,
        'index0'    => 0,
        'revindex'  => 1,
        'revindex0' => 0,
        'first'     => true,
        'last'      => true,
        'length'    => 1,
        'parent'    => [],
      ];
    }
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
