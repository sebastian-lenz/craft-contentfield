<?php

namespace lenz\contentfield\models\fields;

use Craft;
use craft\base\Element;
use craft\base\ElementInterface;
use craft\elements\Asset;
use craft\elements\Category;
use craft\elements\Entry;
use Exception;
use lenz\contentfield\events\ReferenceFolderSourcesEvent;
use lenz\contentfield\events\ReferenceSourcesEvent;
use lenz\contentfield\models\values\ReferenceValue;
use lenz\contentfield\models\values\ValueInterface;
use yii\base\InvalidConfigException;

/**
 * Class ReferenceField
 */
class ReferenceField extends AbstractField
{
  /**
   * @var bool
   */
  public $allowSelfReference = false;

  /**
   * @var null|array
   */
  public $criteria = null;

  /**
   * @var string
   */
  public $elementType = Entry::class;

  /**
   * @var integer|null
   */
  public $limit = null;

  /**
   * @var string|null
   */
  public $modalStorageKey = null;

  /**
   * @var string[]|string|null
   */
  public $sources = null;

  /**
   * @var string
   */
  public $viewMode = 'large';

  /**
   * @var string|string[]|null
   */
  public $with = null;

  /**
   * @var string|string[]|null
   */
  public $withTransforms = null;

  /**
   * The internal name of this field.
   */
  const NAME = 'reference';

  /**
   * Event triggered when this fields collects the available reference sources.
   */
  const EVENT_SOURCES = 'sources';


  /**
   * @inheritdoc
   */
  public function createValue($data, ValueInterface $parent = null) {
    return new ReferenceValue($data, $parent, $this);
  }

  /**
   * @param ElementInterface|null $element
   * @return array|null
   * @throws Exception
   */
  public function getEditorData(ElementInterface $element = null): array {
    return parent::getEditorData() + [
      'allowSelfReference' => !!$this->allowSelfReference,
      'criteria'           => $this->getCriteria($element),
      'elementType'        => $this->getElementType(),
      'limit'              => $this->getLimit(),
      'modalStorageKey'    => $this->modalStorageKey,
      'sources'            => $this->getSources($element),
      'viewMode'           => $this->viewMode,
    ];
  }

  /**
   * @inheritdoc
   * @throws Exception
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
   * @inheritdoc
   */
  public function rules(): array {
    return array_merge(parent::rules(), [
      ['allowSelfReference', 'boolean'],
      ['elementType', 'validateElementType'],
      ['limit', 'integer', 'min' => 1],
      ['modalStorageKey', 'string'],
      ['viewMode', 'in', 'range' => ['large', 'small']]
    ]);
  }

  /**
   * Validates the elementType attribute.
   *
   * @param string $attribute
   * @internal
   * @noinspection PhpUnused (Validator)
   */
  public function validateElementType(string $attribute) {
    $value = $this->$attribute;

    if (!is_string($value) || empty($value)) {
      $this->addError($attribute, "The element type is required.");
    } elseif (is_null(self::resolveElementType($value))) {
      $this->addError($attribute, "Unknown element type '$value'.");
    }
  }


  // Private methods
  // ---------------

  /**
   * @param ElementInterface|null $element
   * @return array
   * @throws Exception
   */
  private function getCriteria(ElementInterface $element = null): array {
    $criteria = is_array($this->criteria)
      ? $this->criteria
      : [];

    if (is_null($element) || !($element instanceof Element)) {
      $criteria['siteId'] = Craft::$app->getSites()->getCurrentSite()->id;
    } else {
      $criteria['siteId'] = $element->siteId;
    }

    return $criteria;
  }

  /**
   * @return integer|null
   */
  private function getLimit(): ?int {
    return isset($this->limit) && is_numeric($this->limit)
      ? intval($this->limit)
      : null;
  }

  /**
   * @param ElementInterface|null $element
   * @return string[]|null
   */
  private function getSources(ElementInterface $element = null): ?array {
    $sources = null;
    if (isset($this->sources)) {
      $sources = self::extractSources($this->sources, $element);
    }

    $eventArgs = [
      'element' => $element,
      'field'   => $this,
      'sources' => $sources,
    ];

    if ($this->elementType == Asset::class) {
      $event = new ReferenceFolderSourcesEvent($eventArgs);
    } else {
      $event = new ReferenceSourcesEvent($eventArgs);
    }

    $this->trigger(self::EVENT_SOURCES, $event);
    return $event->getSources();
  }


  // Static methods
  // --------------

  /**
   * @inheritdoc
   */
  static public function expandFieldConfig(array &$config) {
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

    if (in_array($config['type'], ['category', 'categories'])) {
      $config = array(
        'type'        => self::NAME,
        'elementType' => Category::class,
        'limit'       => $config['type'] == 'category' ? 1 : null,
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
   * Ensures the given element type is the class name of
   * a Craft element class.
   *
   * @param string $elementType
   * @return string|null
   */
  static public function resolveElementType(string $elementType) {
    if (is_subclass_of($elementType, ElementInterface::class)) {
      return $elementType;
    }

    return Craft::$app
      ->getElements()
      ->getElementTypeByRefHandle($elementType);
  }


  // Static private methods
  // ----------------------

  /**
   * @param string[]|string|null $rawValue
   * @param ElementInterface|null $element
   * @return string[]|null
   */
  static private function extractSources($rawValue, ElementInterface $element = null) {
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
   * @return array|string[]
   */
  static private function parseSources($rawValue): array {
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
  static private function splitSourcesString(string $rawValue): array {
    if (!is_string($rawValue) || empty($rawValue)) {
      return [];
    }

    return array_filter(array_map(function($value) {
      return trim($value);
    }, explode(',', $rawValue)));
  }
}
