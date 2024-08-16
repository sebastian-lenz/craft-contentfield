<?php

namespace lenz\contentfield\models\values;

use Craft;
use craft\base\ElementInterface;
use craft\helpers\UrlHelper;
use craft\web\Response;
use Exception;
use lenz\contentfield\behaviors\AnchorBehaviour;
use lenz\contentfield\behaviors\SiblingsBehavior;
use lenz\contentfield\events\BeforeActionEvent;
use lenz\contentfield\helpers\BeforeActionInterface;
use lenz\contentfield\helpers\InstanceAwareInterface;
use lenz\contentfield\helpers\RenderableInterface;
use lenz\contentfield\models\Content;
use lenz\contentfield\models\fields\InstanceField;
use lenz\contentfield\models\schemas\AbstractSchema;
use lenz\contentfield\Plugin;
use lenz\contentfield\twig\DisplayInterface;
use lenz\craft\utils\models\Attributes;
use Twig\Markup;
use yii\base\Model;
use yii\web\Response as YiiResponse;

/**
 * Class InstanceValue
 *
 * @property InstanceField|null $_field
 *
 * Inherited from `AnchorBehaviour`
 * @method AnchorBehaviour[] getAllAnchors()
 * @method string|null getAnchor()
 * @method string|null getAnchorRawValue()
 * @method string|null getAnchorTitle()
 * @method boolean hasAnchor()
 *
 * Inherited from `SiblingsBehavior`
 * @method InstanceValue|null getNextSibling()
 * @method InstanceValue|null getParentInstance()
 * @method InstanceValue|null getPreviousSibling()
 * @method boolean hasNextSibling($qualifier = null)
 * @method boolean hasParentInstance($qualifier = null)
 * @method boolean hasPreviousSibling($qualifier = null)
 */
class InstanceValue
  extends AbstractModelValue
  implements DisplayInterface, RenderableInterface
{
  /**
   * @var Model|null
   */
  private ?Model $_model;

  /**
   * @var string|null
   */
  private ?string $_output = null;

  /**
   * @var string
   */
  private mixed $_originalUuid = null;

  /**
   * @var string
   */
  private mixed $_uuid;

  /**
   * @var bool
   */
  private bool $_visible = true;

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
   * @param Content|null $content
   * @throws Exception
   */
  public function __construct(array $data, AbstractSchema $schema, ValueInterface $parent = null, InstanceField $field = null, Content $content = null) {
    parent::__construct($data, $schema, $parent, $field, $content);

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
  public function __toString(): string {
    return $this->render();
  }

  /**
   * @inheritDoc
   */
  public function behaviors(): array {
    return [
      'anchor' => AnchorBehaviour::class,
      'siblings' => SiblingsBehavior::class,
    ];
  }

  /**
   * @inheritDoc
   * @throws Exception
   */
  public function display(array $variables = []): void {
    if ($this->isVisible()) {
      if (!is_null($this->_output)) {
        echo $this->_output;
      } else {
        $this->getSchema()->display($this, $variables);
      }
    }
  }

  /**
   * @inheritDoc
   */
  public function findUuid(string $uuid): ?InstanceValue {
    return $this->_uuid == $uuid
      ? $this
      : parent::findUuid($uuid);
  }

  /**
   * @return string|null
   * @noinspection PhpUnused (Public API)
   */
  public function getCachedOutput(): ?string {
    return $this->_output;
  }

  /**
   * @return string|null
   * @noinspection PhpUnused (Public API)
   */
  public function getChunkUrl(): ?string {
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
   * @param array $values
   * @return Attributes
   */
  public function getEditAttributes(array $values = []): Attributes {
    $attributes = new Attributes($values);
    if (Plugin::$IS_ELEMENT_PREVIEW) {
      $attributes->set('data-contentfield-edit-uuid', $this->_uuid);
    }

    return $attributes;
  }

  /**
   * @inheritDoc
   */
  public function getEditorValue(): array {
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
  public function getHtml(array $variables = []): Markup {
    return new Markup($this->render($variables), 'utf-8');
  }

  /**
   * @return Model|null
   * @throws Exception
   */
  public function getModel(): ?Model {
    if (!isset($this->_model)) {
      $this->_model = $this->createModel();
    }

    return $this->_model;
  }

  /**
   * @return string
   */
  public function getNamespace(): string {
    return 'cn' . substr($this->_uuid, -12);
  }

  /**
   * @return string|null
   * @noinspection PhpUnused (Public API)
   */
  public function getOriginalUuid(): ?string {
    return $this->_originalUuid;
  }

  /**
   * @inheritDoc
   */
  public function getSerializedValue(ElementInterface $element = null): array {
    return parent::getSerializedValue($element) + [
      self::ORIGINAL_UUID_PROPERTY => $this->_originalUuid,
      self::TYPE_PROPERTY          => $this->getSchema()->qualifier,
      self::UUID_PROPERTY          => $this->_uuid,
      self::VISIBLE_PROPERTY       => $this->_visible,
    ];
  }

  /**
   * @return string
   */
  public function getUuid(): string {
    return $this->_uuid;
  }

  /**
   * @return bool
   * @noinspection PhpUnused
   */
  public function hasCachedOutput(): bool {
    return !is_null($this->_output);
  }

  /**
   * @return bool
   */
  public function isVisible(): bool {
    return $this->_visible;
  }

  /**
   * @inheritDoc
   * @throws Exception
   */
  public function onBeforeAction(BeforeActionEvent $event): void {
    parent::onBeforeAction($event);

    $model = $this->getModel();
    if ($model instanceof BeforeActionInterface) {
      $model->onBeforeAction($event);
    }

    if ($event->requestedUuid == $this->_uuid) {
      $event->originalEvent->isValid = false;
      $this->handleChunkRequest();
    }
  }

  /**
   * @inheritDoc
   */
  public function render(array $variables = [], array $options = []): string {
    if (!$this->isVisible()) {
      return '';
    }

    if (!is_null($this->_output)) {
      return $this->_output;
    }

    return $this
      ->getSchema()
      ->render($this, $variables, $options);
  }

  /**
   * @param string|null $value
   * @noinspection PhpUnused (Public API)
   */
  public function setCachedOutput(?string $value): void {
    $this->_output = $value;
  }


  // Private methods
  // ---------------

  /**
   * @return Model|null
   * @throws Exception
   */
  private function createModel(): ?Model {
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
  private function handleChunkRequest(): void {
    $response = Craft::$app->response;
    if (!($response instanceof Response)) {
      throw new Exception('Chunk requests are only supported on web requests.');
    }

    $content = $this->render([
      'isChunkRequest' => true
    ]);

    if (Craft::$app->getRequest()->getAcceptsJson()) {
      $response->format = YiiResponse::FORMAT_JSON;
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
  static function uuid(): string {
    $data = random_bytes(16);
    $data[6] = chr(ord($data[6]) & 0x0f | 0x40); // set version to 0100
    $data[8] = chr(ord($data[8]) & 0x3f | 0x80); // set bits 6-7 to 10

    return vsprintf('%s%s-%s-%s-%s-%s%s%s', str_split(bin2hex($data), 4));
  }
}
