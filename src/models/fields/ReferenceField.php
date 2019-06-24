<?php

namespace lenz\contentfield\models\fields;

use craft\base\Element;
use Exception;
use lenz\contentfield\models\values\ReferenceValue;
use lenz\contentfield\models\values\ValueInterface;
use craft\base\ElementInterface;
use craft\elements\Asset;
use craft\elements\Entry;
use yii\base\InvalidConfigException;

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
  public function createValue($data, ValueInterface $parent) {
    return new ReferenceValue($data, $parent, $this);
  }

  /**
   * @param ElementInterface|null $element
   * @return array|null
   * @throws Exception
   */
  public function getEditorData(ElementInterface $element = null) {
    return parent::getEditorData() + array(
        'criteria'    => is_array($this->criteria) ? $this->criteria : null,
        'elementType' => $this->getElementType(),
        'limit'       => $this->getLimit(),
        'sources'     => $this->getSources($element),
        'viewMode'    => $this->viewMode,
      );
  }

  /**
   * @inheritdoc
   */
  public function getEditorValue($value) {
    if (!($value instanceof ReferenceValue)) {
      return null;
    }

    return array_map(function(ElementInterface $element) {
      return intval($element->getId());
    }, $value->getReferences());
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
   * @param ElementInterface|null $element
   * @return string[]|null
   */
  public function getSources(ElementInterface $element = null) {
    if (isset($this->sources)) {
      return self::extractSources($this->sources, $element);
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


  // Static methods
  // --------------

  /**
   * @inheritdoc
   */
  static function expandFieldConfig(&$config) {
    // Expand the type `instances` to an array of instance fields
    if (in_array($config['type'], ['image', 'images'])) {
      $config = array(
        'type'        => self::NAME,
        'criteria'    => [
          'kind'      => 'image',
        ],
        'elementType' => Asset::class,
        'limit'       => $config['type'] == 'image' ? 1 : null,
      ) + $config;
    }

    if (in_array($config['type'], ['asset', 'assets', 'file', 'files'])) {
      $config = array(
        'type'        => self::NAME,
        'elementType' => Asset::class,
        'limit'       => in_array($config['type'], ['asset', 'file']) ? 1 : null,
        'viewMode'    => 'small'
      ) + $config;
    }

    if (in_array($config['type'], ['entry', 'entries'])) {
      $config = array(
        'type'        => self::NAME,
        'elementType' => Entry::class,
        'limit'       => $config['type'] == 'entry' ? 1 : null,
        'viewMode'    => 'small'
      ) + $config;
    }
  }

  /**
   * @param string $rawValue
   * @param ElementInterface|null $element
   * @return string[]|null
   */
  static function extractSources($rawValue, ElementInterface $element = null) {
    $sources = self::parseSources($rawValue);

    try {
      $site = $element instanceof Element
        ? $element->getSite()->handle
        : '*';
    } catch (InvalidConfigException $error) {
      $site = '*';
    }

    if (array_key_exists($site, $sources)) {
      return $sources[$site];
    }

    return array_key_exists('*', $sources)
      ? $sources['*']
      : null;
  }

  /**
   * Parses the sources attribute of a reference field. Returns
   * an array which keys contain site handles and the value a list
   * of sources. The key `*` contains the default sources.
   *
   * We accept the following formats:
   *
   * - Single source as string, e.g.:
   *   ```
   *   sources: section:8e15181e-dd0c-49a3-9741-e9bdbf39ad23
   *   ```
   *
   * - Multiple sources, comma separated, e.g.:
   *   ```
   *   sources: section:8e15181e-dd0c-49a3-9741-e9bdbf39ad23,section:a976f2d5-928e-4040-ad10-00fd6e3011d3
   *   ```
   *
   * - Multiple sources, as array, e.g.:
   *   ```
   *   sources:
   *   - section:8e15181e-dd0c-49a3-9741-e9bdbf39ad23
   *   - section:a976f2d5-928e-4040-ad10-00fd6e3011d3
   *   ```
   *
   * - Sources per site, e.g.:
   *   ```
   *   sources:
   *     "*": section:2c6692f4-0116-4f9a-b1cb-b61f72b2031e
   *     "firstSite": section:5766d986-886f-45d5-8e11-26076cf2bef6,section:18562552-2f6d-45c9-bb8d-ea693ec345b4
   *     "secondSite,thirdSite":
   *       - section:8e15181e-dd0c-49a3-9741-e9bdbf39ad23
   *       - section:a976f2d5-928e-4040-ad10-00fd6e3011d3
   *   ```
   *
   * @param string[]|string|null $rawValue
   * @return array|string|string[]|null
   */
  static function parseSources($rawValue) {
    if (is_array($rawValue)) {
      $sources = [];

      foreach ($rawValue as $key => $value) {
        $siteSources = is_array($value) ? $value : self::splitSourcesString($value);
        $sites = is_numeric($key) ? '*' : $key;

        foreach (explode(',', $sites) as $site) {
          $sources[$site] = !isset($sources[$site])
            ? $siteSources
            : array_merge($sources[$site], $siteSources);
        }
      }

      return $sources;
    }

    return [
      '*' => self::splitSourcesString($rawValue)
    ];
  }

  /**
   * @param string $rawValue
   * @return string[]
   */
  static public function splitSourcesString($rawValue) {
    if (!is_string($rawValue) || !empty($rawValue)) {
      return [];
    }

    return array_filter(array_map(function($value) {
      return trim($value);
    }, explode(',', $rawValue)));
  }
}
