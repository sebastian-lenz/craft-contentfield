<?php

namespace contentfield\models\fields;

use contentfield\models\values\AbstractValue;
use craft\base\ElementInterface;

use contentfield\models\schemas\AbstractSchema;
use contentfield\models\values\InstanceValue;
use contentfield\models\widgets\InstanceWidget;
use contentfield\Plugin;

/**
 * Class InstanceField
 *
 * A field that stores another ContentModel.
 */
class InstanceField extends AbstractField
{
  /**
   * @var AbstractSchema[]
   */
  public $schemas;

  /**
   * @inheritdoc
   */
  const DEFAULT_WIDGET = InstanceWidget::NAME;

  /**
   * The internal name of this field.
   */
  const NAME = 'instance';

  /**
   * @inheritdoc
   */
  const VALUE_CLASS = InstanceValue::class;


  /**
   * ArrayField constructor.
   *
   * @param array $config
   * @throws \Exception
   */
  public function __construct(array $config = []) {
    if (array_key_exists('schemas', $config)) {
      $schemaManager = Plugin::getSchemaManager();
      $specs = array_filter(array_map(function($spec) {
        return trim($spec);
      }, explode(',', $config['schemas'])));

      $config['schemas'] = $schemaManager->getSchemas($specs);
    }

    parent::__construct($config);
  }

  /**
   * @inheritdoc
   */
  public function createValue($data, AbstractValue $parent) {
    return Plugin::getSchemaManager()->createValue($data, $parent, $this);
  }

  /**
   * @inheritdoc
   */
  public function getDependedSchemas() {
    return $this->schemas;
  }

  /**
   * @inheritdoc
   */
  public function getEditorData(ElementInterface $element = null) {
    if (!is_array($this->schemas) || count($this->schemas) === 0) {
      return null;
    }

    $schemas = array();
    foreach ($this->schemas as $schema) {
      $schemas[] = $schema->qualifier;
    }

    return parent::getEditorData($element) + array(
        'schemas' => $schemas,
      );
  }
}
