<?php

namespace lenz\contentfield\models\values;

use Craft;
use craft\helpers\Template;
use craft\helpers\UrlHelper;
use craft\web\Response;
use Exception;
use lenz\contentfield\behaviors\InstanceSiblingsBehavior;
use lenz\contentfield\events\BeforeActionEvent;
use lenz\contentfield\helpers\BeforeActionInterface;
use lenz\contentfield\helpers\InstanceAwareInterface;
use lenz\contentfield\models\fields\InstanceField;
use lenz\contentfield\models\schemas\AbstractSchema;
use lenz\contentfield\Plugin;
use lenz\contentfield\twig\DisplayInterface;
use Twig\Markup;
use yii\base\Model;

/**
 * Class InstanceValue
 *
 * @property InstanceField|null $_field
 * @method InstanceValue|null getNextSibling()
 * @method InstanceValue|null getParentInstance()
 * @method InstanceValue|null getPreviousSibling()
 * @method boolean hasNextSibling($qualifier = null)
 * @method boolean hasParentInstance($qualifier = null)
 * @method boolean hasPreviousSibling($qualifier = null)
 */
class InstanceValue extends AbstractModelValue implements DisplayInterface
{
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
   * @var string
   */
  private $_uuid;

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
    parent::__construct($data, $schema, $parent, $field);

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
        $this->getSchema()->display($this, $variables);
      }
    }
  }

  /**
   * @inheritDoc
   */
  public function findUuid(string $uuid) {
    return $this->_uuid == $uuid
      ? $this
      : parent::findUuid($uuid);
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
    return parent::getEditorValue() + [
      self::ERRORS_PROPERTY        => $this->getErrors(),
      self::ORIGINAL_UUID_PROPERTY => $this->_originalUuid,
      self::TYPE_PROPERTY          => $this->getSchema()->qualifier,
      self::UUID_PROPERTY          => $this->_uuid,
      self::VISIBLE_PROPERTY       => $this->_visible,
    ];
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
      $this->_model = $this->createModel();
    }

    return $this->_model;
  }

  /**
   * @return string
   */
  public function getNamespace() {
    return 'cn' . substr($this->_uuid, -12);
  }

  /**
   * @return string|null
   */
  public function getOriginalUuid() {
    return $this->_originalUuid;
  }

  /**
   * @inheritDoc
   */
  public function getSerializedValue() {
    return parent::getSerializedValue() + [
      self::ORIGINAL_UUID_PROPERTY => $this->_originalUuid,
      self::TYPE_PROPERTY          => $this->getSchema()->qualifier,
      self::UUID_PROPERTY          => $this->_uuid,
      self::VISIBLE_PROPERTY       => $this->_visible,
    ];
  }

  /**
   * @return string
   */
  public function getUuid() {
    return $this->_uuid;
  }

  /**
   * @return bool
   */
  public function hasCachedOutput() {
    return isset($this->_output);
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
    parent::onBeforeAction($event);

    $model = $this->getModel();
    if (!is_null($model) && $model instanceof BeforeActionInterface) {
      $model->onBeforeAction($event);
    }

    if ($event->requestedUuid == $this->_uuid) {
      $event->originalEvent->isValid = false;
      $this->handleChunkRequest();
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

    return $this->getSchema()
      ->render($this, $variables, $options);
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
   * @return Model|null
   * @throws Exception
   */
  private function createModel() {
    $model = $this->getSchema()->model;
    if (empty($model)) {
      return null;
    }

    $instance = new $model();
    if (!($instance instanceof Model)) {
      throw new Exception('Invalid model class ' . $model);
    }

    if ($instance instanceof InstanceAwareInterface) {
      $instance->setInstance($this);
    }

    return $instance;
  }

  /**
   * @throws Exception
   */
  private function handleChunkRequest() {
    $response = Craft::$app->response;
    if (!($response instanceof Response)) {
      throw new Exception('Chunk requests are only supported on web requests.');
    }

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
