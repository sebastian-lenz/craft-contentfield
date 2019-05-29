<?php

namespace lenz\contentfield\models\values;

use craft\helpers\UrlHelper;
use craft\web\Response;
use lenz\contentfield\events\BeforeActionEvent;
use lenz\contentfield\models\BeforeActionInterface;
use lenz\contentfield\models\fields\AbstractField;
use lenz\contentfield\models\fields\InstanceField;
use lenz\contentfield\models\InstanceAwareInterface;
use lenz\contentfield\models\schemas\AbstractSchema;
use lenz\contentfield\models\schemas\TemplateSchema;
use lenz\contentfield\Plugin;
use lenz\contentfield\utilities\ReferenceMap;
use lenz\contentfield\utilities\twig\DisplayInterface;
use yii\base\Model;

/**
 * Class InstanceValue
 *
 * @property InstanceField|null $_field
 */
class InstanceValue
  extends Model
  implements BeforeActionInterface, DisplayInterface, ValueInterface
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
  private $_originalUuid;

  /**
   * @var AbstractSchema
   */
  private $_schema;

  /**
   * @var string
   */
  private $_uuid;

  /**
   * @var ValueInterface[]
   */
  private $_values = array();

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
   * @throws \Exception
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

    foreach ($schema->fields as $name => $field) {
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
    } else {
      return parent::__get($name);
    }
  }

  /**
   * @inheritdoc
   * @throws \Exception
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
    } else {
      return parent::__isset($name);
    }
  }

  /**
   * @inheritdoc
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
      if (!is_null($value)) {
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
      if (!is_null($value)) {
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
  public function getEditorData() {
    $result = array(
      self::ERRORS_PROPERTY        => $this->getErrors(),
      self::ORIGINAL_UUID_PROPERTY => $this->_originalUuid,
      self::TYPE_PROPERTY          => $this->_schema->qualifier,
      self::UUID_PROPERTY          => $this->_uuid,
    );

    foreach ($this->_values as $name => $value) {
      if (!is_null($value)) {
        $result[$name] = $value->getEditorData();
      }
    }

    return $result;
  }

  /**
   * @inheritdoc
   */
  public function getHtml(array $variables = []) {
    return new \Twig_Markup($this->render($variables), 'utf-8');
  }

  /**
   * @return Model|null
   * @throws \Exception
   */
  public function getModel() {
    if (!isset($this->_model)) {
      $schema     = $this->_schema;
      $modelClass = $schema instanceof TemplateSchema ? $schema->model : null;
      $model      = null;

      if (!empty($modelClass)) {
        $model = new $modelClass();

        if (!($model instanceof Model)) {
          throw new \Exception('Invalid model class ' . $modelClass);
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

    foreach ($this->_values as $field) {
      if (!is_null($field)) {
        $field->getReferenceMap($map);
      }
    }

    return $map;
  }

  /**
   * @inheritDoc
   */
  public function getSearchKeywords() {
    return implode(' ', array_map(function(ValueInterface $value) {
      $value->getSearchKeywords();
    }, $this->_values));
  }

  /**
   * @return array
   */
  public function getSerializedData() {
    $result = array();
    foreach ($this->_values as $name => $value) {
      if (!is_null($value)) {
        $result[$name] = $value->getSerializedData();
      }
    }

    $result[self::TYPE_PROPERTY] = $this->_schema->qualifier;
    $result[self::UUID_PROPERTY] = $this->_uuid;
    $result[self::ORIGINAL_UUID_PROPERTY] = $this->_originalUuid;
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
   * @return ValueInterface[]
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
   * @return bool
   */
  public function isEmpty() {
    return false;
  }

  /**
   * @inheritDoc
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
      $response = \Craft::$app->response;
      $content = $this->render([
        'isChunkRequest' => true
      ]);

      if (\Craft::$app->getRequest()->getAcceptsJson()) {
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
   * @return string
   */
  public function render(array $variables = []) {
    if (isset($this->_output)) {
      return $this->_output;
    }

    $this->normalizeVariables($variables);
    return $this->_schema->render($this, $variables);
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
   */
  private function normalizeVariables(array &$variables) {
    $variables += [
      'isChunkRequest' => false,
      'model'          => $this->getModel(),
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
   * @throws \Exception
   */
  static function uuid() {
    $data = random_bytes(16);
    $data[6] = chr(ord($data[6]) & 0x0f | 0x40); // set version to 0100
    $data[8] = chr(ord($data[8]) & 0x3f | 0x80); // set bits 6-7 to 10

    return vsprintf('%s%s-%s-%s-%s-%s%s%s', str_split(bin2hex($data), 4));
  }
}
