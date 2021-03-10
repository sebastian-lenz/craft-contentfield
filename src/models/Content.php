<?php

namespace lenz\contentfield\models;

use Craft;
use craft\base\Element;
use craft\base\ElementInterface;
use craft\helpers\Json;
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
use Throwable;
use Twig\Markup;

/**
 * Class Content
 * @method ContentField getField()
 * @property ContentField $_field
 */
class Content extends ForeignFieldModel implements DisplayInterface
{
  /**
   * @var ContentLoadException
   */
  private $_loadError;

  /**
   * @var values\InstanceValue|null
   */
  private $_model;

  /**
   * @var ReferenceLoader
   */
  private $_referenceLoader;

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
  public function attributes() {
    return ['model'];
  }

  /**
   * @inheritDoc
   * @throws Exception
   */
  public function display(array $variables = []) {
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
   */
  public function findUuid(string $uuid) {
    $model = $this->getModel();
    return is_null($model) ? null : $model->findUuid($uuid);
  }

  /**
   * @return mixed
   */
  public function getEditorValue() {
    return is_null($this->_model)
      ? null
      : $this->_model->getEditorValue();
  }

  /**
   * @param array $variables
   * @return Markup
   * @throws Exception
   */
  public function getHtml(array $variables = []) {
    return new Markup($this->render($variables), 'utf-8');
  }

  /**
   * @return ContentLoadException|null
   */
  public function getLoadError() {
    return isset($this->_loadError) ? $this->_loadError : null;
  }

  /**
   * @return values\InstanceValue|null
   */
  public function getModel() {
    return $this->_model;
  }

  /**
   * @return ElementInterface|null
   */
  public function getOwner() {
    return $this->_owner;
  }

  /**
   * @return Site
   */
  public function getOwnerSite() {
    if ($this->_owner instanceof Element) {
      try {
        return $this->_owner->getSite();
      } catch (Exception $e) {
        // Ignore this error
      }
    }

    return Craft::$app->sites->currentSite;
  }

  /**
   * @return int[]
   */
  public function getReferencedIds() {
    $result = [];
    if (
      is_null($this->_model) ||
      !($this->_model instanceof values\InstanceValue)
    ) {
      return $result;
    }

    $siteId = $this->getOwnerSite()->id;

    return array_map(function(ElementInterface $element) {
      return $element->getId();
    }, $this->_model->getReferenceMap()->queryAll($siteId));
  }

  /**
   * @return ReferenceLoader
   * @throws Exception
   */
  public function getReferenceLoader() {
    if (!isset($this->_referenceLoader)) {
      $this->_referenceLoader = new ReferenceLoader($this);
    }

    return $this->_referenceLoader;
  }

  /**
   * @return string
   */
  public function getSearchKeywords() {
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
  public function render(array $variables = [], array $options = []) {
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
   * @param InstanceValue|string|null|mixed $value
   * @throws Throwable
   */
  public function setModel($value = null) {
    $model   = null;
    $schemas = Plugin::getInstance()->schemas;

    try {
      if ($value instanceof InstanceValue) {
        $model = $value;
      } elseif (is_string($value)) {
        $model = $schemas->createValue(ContentRecord::decodeModel($value));
      } elseif (is_array($value)) {
        $model = $schemas->createValue($value);
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
  public function validate($attributeNames = null, $clearErrors = true) {
    $model = $this->getModel();
    if (is_null($model)) {
      return true;
    }

    return $model->validate();
  }
}
