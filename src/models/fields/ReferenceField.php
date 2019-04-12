<?php

namespace sebastianlenz\contentfield\models\fields;

use sebastianlenz\contentfield\models\values\AbstractValue;
use craft\base\ElementInterface;
use craft\elements\Asset;
use craft\elements\Entry;

use sebastianlenz\contentfield\models\values\ReferenceValue;

/**
 * Class ReferenceField
 */
class ReferenceField extends AbstractField
{
  /**
   * @var array
   */
  public $criteria;

  /**
   * @var string
   */
  public $elementType;

  /**
   * @var integer|null
   */
  public $limit;

  /**
   * @var string[]|string|null
   */
  public $sources;

  /**
   * @var string
   */
  public $viewMode;

  /**
   * The internal name of this field.
   */
  const NAME = 'reference';


  /**
   * @inheritdoc
   */
  public function createValue($data, AbstractValue $parent) {
    return new ReferenceValue($data, $parent, $this);
  }

  /**
   * @return string|null
   */
  public function getElementType() {
    return isset($this->elementType)
      ? self::resolveElementType($this->elementType)
      : null;
  }

  /**
   * @return integer|null
   */
  public function getLimit() {
    if (isset($this->limit)) {
      return $this->limit;
    }

    if (isset($this->elementType) && is_string($this->elementType)) {
      $elementType = strtolower($this->elementType);
      if (
        $elementType === 'asset' ||
        $elementType === 'entry'
      ) {
        return 1;
      }
    }

    return null;
  }

  /**
   * @return string[]|null
   */
  public function getSources() {
    if (isset($this->sources)) {
      if (is_array($this->sources)) {
        return $this->sources;
      } elseif (is_string($this->sources) && !empty($this->sources)) {
        return array_filter(array_map(function($value) {
          return trim($value);
        }, explode(',', $this->sources)));
      }
    }

    return null;
  }

  /**
   * @inheritdoc
   */
  public function rules() {
    return array_merge(
      parent::rules(),
      array(
        array('elementType', 'validateElementType'),
        array('limit',       'integer', 'min' => 1),
        array('viewMode',    'default', 'value' => 'large'),
        array('viewMode',    'in', 'range' => array('large', 'small'))
      )
    );
  }

  /**
   * @param ElementInterface|null $element
   * @return array|null
   * @throws \Exception
   */
  public function getEditorData(ElementInterface $element = null) {
    return parent::getEditorData() + array(
      'criteria'    => is_array($this->criteria) ? $this->criteria : null,
      'elementType' => $this->getElementType(),
      'limit'       => $this->getLimit(),
      'sources'     => $this->getSources(),
      'viewMode'    => $this->viewMode,
    );
  }

  /**
   * @param $attribute
   */
  public function validateElementType($attribute) {
    if (!isset($this->$attribute) || empty($this->$attribute) || !is_string($this->$attribute)) {
      $this->addError($attribute, "The element type is required.");
    } elseif (is_null(self::resolveElementType($this->$attribute))) {
      $this->addError($attribute, "Unknown element type '{$this->$attribute}'.");
    }
  }

  /**
   * @param string $elementType
   * @return string|null
   */
  public function resolveElementType($elementType) {
    if (!is_string($elementType)) {
      return null;
    }

    switch (strtolower($elementType)) {
      case 'asset':
      case 'assets':
        return Asset::class;
      case 'entry':
      case 'entries':
        return Entry::class;
    }

    return class_exists($this->elementType)
      ? $this->elementType
      : null;
  }

  /**
   * @inheritdoc
   */
  static function expandFieldConfig(&$config) {
    // Expand the type `instances` to an array of instance fields
    if (
      $config['type'] === 'image' ||
      $config['type'] === 'images'
    ) {
      $config = array(
        'type'        => self::NAME,
        'elementType' => Asset::class,
        'limit'       => $config['type'] === 'image' ? 1 : null,
      ) + $config;
    }

    if (
      $config['type'] === 'file' ||
      $config['type'] === 'files'
    ) {
      $config = array(
        'type'        => self::NAME,
        'elementType' => Asset::class,
        'limit'       => $config['type'] === 'file' ? 1 : null,
        'viewMode'    => 'small'
      ) + $config;
    }

    if (
      $config['type'] === 'entry' ||
      $config['type'] === 'entries'
    ) {
      $config = array(
        'type'        => self::NAME,
        'elementType' => Entry::class,
        'limit'       => $config['type'] === 'entry' ? 1 : null,
        'viewMode'    => 'small'
      ) + $config;
    }
  }
}
