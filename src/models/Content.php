<?php

namespace lenz\contentfield\models;

use Craft;
use craft\base\Element;
use craft\base\ElementInterface;
use craft\models\Site;
use Exception;
use lenz\contentfield\events\BeforeActionEvent;
use lenz\contentfield\events\RenderEvent;
use lenz\contentfield\exceptions\ContentLoadException;
use lenz\contentfield\fields\ContentField;
use lenz\contentfield\helpers\ReferenceLoader;
use lenz\contentfield\models\values\InstanceValue;
use lenz\contentfield\Plugin;
use lenz\contentfield\records\ContentRecord;
use lenz\contentfield\twig\DisplayInterface;
use lenz\craft\utils\foreignField\ForeignField;
use lenz\craft\utils\foreignField\ForeignFieldModel;
use lenz\craft\utils\helpers\ArrayHelper;
use Throwable;
use Twig\Markup;

/**
 * Class Content
 *
 * @method ContentField getField()
 * @property ContentField $_field
 */
class Content extends ForeignFieldModel implements DisplayInterface
{
  /**
   * @var ContentLoadException
   */
  private ContentLoadException $_loadError;

  /**
   * @var InstanceValue|null
   */
  private ?InstanceValue $_model = null;

  /**
   * @var ReferenceLoader
   */
  private ReferenceLoader $_referenceLoader;

  /**
   * Event triggered before some content is rendered.
   */
  const EVENT_BEFORE_RENDER = 'beforeRender';


  /**
   * Content constructor.
   * @param ForeignField $field
   * @param ElementInterface|null $owner
   * @param array $config
   */
  public function __construct(ForeignField $field, ElementInterface $owner = null, array $config = []) {
    // Legacy support: we serialized the entire model directly to the
    // revision table in past versions
    if (array_key_exists('__type', $config)) {
      $config = ['model' => $config];
    }

    parent::__construct($field, $owner, $config);
  }

  /**
   * @return string
   * @throws Exception
   */
  public function __toString() {
    return (string)$this->getHtml();
  }

  /**
   * @inheritDoc
   */
  public function attributes(): array {
    return ['model'];
  }

  /**
   * @param ElementInterface $element
   * @param bool $isNew
   * @return void
   */
  public function beforeElementSave(ElementInterface $element, bool $isNew): void {
    $model = $this->_model;
    if (empty($model)) {
      return;
    }

    foreach ($this->_model->getSchema()->fields as $field) {
      $field->beforeElementSave($element, $model, $isNew);
    }
  }

  /**
   * @inheritDoc
   * @throws Exception
   */
  public function display(array $variables = []): void {
    $model = $this->_model;
    if (!is_null($model)) {
      $this->trigger(self::EVENT_BEFORE_RENDER, new RenderEvent([
        'content' => $this,
      ]));

      $model->display($variables);
    }
  }

  /**
   * @param string $uuid
   * @return InstanceValue|null
   * @noinspection PhpUnused (Public API)
   */
  public function findUuid(string $uuid): ?InstanceValue {
    $model = $this->getModel();
    return is_null($model) ? null : $model->findUuid($uuid);
  }

  /**
   * @return array|null
   */
  public function getEditorValue(): ?array {
    return is_null($this->_model)
      ? null
      : $this->_model->getEditorValue();
  }

  /**
   * @param array $variables
   * @return Markup
   * @throws Exception
   */
  public function getHtml(array $variables = []): Markup {
    return new Markup($this->render($variables), 'utf-8');
  }

  /**
   * @return ContentLoadException|null
   * @noinspection PhpUnused
   */
  public function getLoadError(): ?ContentLoadException {
    return $this->_loadError ?? null;
  }

  /**
   * @return InstanceValue|null
   */
  public function getModel(): ?InstanceValue {
    return $this->_model;
  }

  /**
   * @return ElementInterface|null
   */
  public function getOwner(): ?ElementInterface {
    return $this->_owner;
  }

  /**
   * @return Site
   */
  public function getOwnerSite(): Site {
    if ($this->_owner instanceof Element) {
      try {
        return $this->_owner->getSite();
      } catch (Exception) {
        // Ignore this error
      }
    }

    return Craft::$app->sites->currentSite;
  }

  /**
   * @return int[]
   */
  public function getReferencedIds(): array {
    $result = [];
    if (!($this->_model instanceof values\InstanceValue)) {
      return $result;
    }

    $siteId = $this->getOwnerSite()->id;

    return array_map(
      fn(ElementInterface $element) => $element->getId(),
      $this->_model->getReferenceMap()->queryAll($siteId)
    );
  }

  /**
   * @return ReferenceLoader
   */
  public function getReferenceLoader(): ReferenceLoader {
    if (!isset($this->_referenceLoader)) {
      $this->_referenceLoader = new ReferenceLoader($this);
    }

    return $this->_referenceLoader;
  }

  /**
   * @return string
   */
  public function getSearchKeywords(): string {
    return is_null($this->_model)
      ? ''
      : $this->_model->getSearchKeywords();
  }

  /**
   * @param BeforeActionEvent $event
   * @throws Exception
   */
  public function onBeforeAction(BeforeActionEvent $event) {
    $model = $this->getModel();
    if (!$model) {
      return;
    }

    if ($this->_field->useAsPageTemplate) {
      $model->getSchema()->applyPageTemplate($event, $this);
    }

    if (!$event->isPreviewRequest) {
      $model->onBeforeAction($event);
    }
  }

  /**
   * @param array $variables
   * @param array $options
   * @return string
   * @throws Exception
   */
  public function render(array $variables = [], array $options = []): string {
    $model = $this->_model;
    if (is_null($model)) {
      return '';
    }

    $this->trigger(self::EVENT_BEFORE_RENDER, new RenderEvent([
      'content' => $this,
      'options' => $options,
    ]));

    return $model->render($variables, $options);
  }

  /**
   * @param mixed $value
   * @throws Throwable
   */
  public function setModel(mixed $value = null) {
    $model   = null;
    $schemas = Plugin::getInstance()->schemas;

    try {
      if ($value instanceof InstanceValue) {
        $model = $value;
      } elseif (is_string($value)) {
        $model = $schemas->createValue(ContentRecord::decodeModel($value), null, null, $this);
      } elseif (is_array($value)) {
        $model = $schemas->createValue($value, null, null, $this);
      }

      // If we have a model, check whether the type is allowed
      $schemas = $this->_field->getRootSchemas($this->_owner);
      $schemaTypes = array_map(
        function($schema) { return $schema->qualifier; },
        $schemas
      );

      if (
        !is_null($model) &&
        !in_array($model->getSchema()->qualifier, $schemaTypes)
      ) {
        $model = null;
      }

      // If we don't have a model and there is only one schema
      // available, create a model from it
      if (is_null($model) && count($schemas) === 1) {
        $model = new InstanceValue([], reset($schemas), null, null);
      }
    } catch (ContentLoadException $error) {
      $this->_loadError = $error;
    }

    if (!is_null($model)) {
      $model->setContent($this);
    }

    $this->_model = $model;
  }

  /**
   * @param ReferenceLoader $referenceLoader
   * @throws Exception
   */
  public function setReferenceLoader(ReferenceLoader $referenceLoader) {
    $referenceLoader->addContent($this);
    $this->_referenceLoader = $referenceLoader;
  }

  /**
   * @inheritDoc
   */
  public function validate($attributeNames = null, $clearErrors = true): bool {
    $model = $this->getModel();
    if (is_null($model)) {
      return true;
    }

    return $model->validate();
  }


  // Protected methods
  // -----------------

  /**
   * @inheritDoc
   */
  protected function getSerializedData(): array {
    return array_merge(parent::getSerializedData(), [
      '_attributes' => [],
      '_model' => $this->_model?->getSerializedValue(),
    ]);
  }

  /**
   * @inheritDoc
   */
  protected function setSerializedData(array $data) {
    parent::setSerializedData($data);
    try {
      $this->setModel(ArrayHelper::get($data, '_model'));
    } catch (Throwable) {
      // Ignore, let the deserialization move on
    }
  }
}
