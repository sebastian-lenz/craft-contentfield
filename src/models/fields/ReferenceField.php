<?php

namespace lenz\contentfield\models\fields;

use Craft;
use craft\base\conditions\ConditionInterface;
use craft\base\Element;
use craft\base\ElementInterface;
use craft\elements\Asset;
use craft\elements\Category;
use craft\elements\conditions\ElementCondition;
use craft\elements\Entry;
use craft\errors\SiteNotFoundException;
use craft\helpers\StringHelper;
use craft\models\Site;
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
  public bool $allowSelfReference = false;

  /**
   * @var ConditionInterface|array|null
   */
  public ConditionInterface|array|null $condition = null;

  /**
   * @var null|array
   */
  public ?array $criteria = null;

  /**
   * @var string
   */
  public string $elementType = Entry::class;

  /**
   * @var integer|null
   */
  public ?int $limit = null;

  /**
   * @var string|null
   */
  public ?string $modalStorageKey = null;

  /**
   * @var string|bool
   */
  public string|bool $showSiteMenu = false;

  /**
   * @var string[]|string|null
   */
  public string|array|null $sources = null;

  /**
   * @var string|int|null
   */
  public string|int|null $targetSite = null;

  /**
   * @var string
   */
  public string $viewMode = 'cards';

  /**
   * @var string|string[]|null
   */
  public string|array|null $with = null;

  /**
   * @var string|string[]|null
   */
  public string|array|null $withTransforms = null;

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
  public function createValue(mixed $data, ValueInterface $parent = null): ReferenceValue {
    return new ReferenceValue($data, $parent, $this);
  }

  /**
   * @return ConditionInterface|null
   * @throws InvalidConfigException
   */
  public function getCondition(): ?ConditionInterface {
    if ($this->condition !== null && !$this->condition instanceof ConditionInterface) {
      $this->condition = Craft::$app->getConditions()->createCondition($this->condition);
    }

    return $this->condition;
  }

  /**
   * @param ElementInterface|null $element
   * @return array
   * @throws Exception
   */
  public function getEditorData(ElementInterface $element = null): array {
    $condition = $this->getCondition();
    if ($element && $condition instanceof ElementCondition) {
      $condition->referenceElement = $element;
    }

    return parent::getEditorData() + [
      'allowSelfReference'     => !!$this->allowSelfReference,
      'condition'              => $condition ? $condition->getConfig() : null,
      'criteria'               => $this->getCriteria($element),
      'elementType'            => $this->getElementType(),
      'limit'                  => $this->getLimit(),
      'modalStorageKey'        => $this->modalStorageKey,
      'referenceElementId'     => $element?->id,
      'referenceElementSiteId' => $element?->siteId,
      'showSiteMenu'           => $this->getShowSiteMenu(),
      'sources'                => $this->getSources($element),
      'viewMode'               => $this->viewMode,
    ];
  }

  /**
   * @inheritdoc
   * @throws Exception
   */
  public function getEditorValue(mixed $value): ?array {
    if (!($value instanceof ReferenceValue)) {
      return null;
    }

    return array_map(
      fn(ElementInterface $element) => [
        'id' => $element->id,
        'siteId' => $element->siteId,
      ],
      $value->getReferences()
    );
  }

  /**
   * @return class-string<Element>|null
   */
  public function getElementType(): string|null {
    return isset($this->elementType)
      ? self::resolveElementType($this->elementType)
      : null;
  }

  /**
   * @param mixed $value
   * @param ElementInterface|null $element
   * @return mixed
   * @throws SiteNotFoundException
   */
  public function getSerializedValue(mixed $value, ElementInterface $element = null): mixed {
    $result = parent::getSerializedValue($value, $element);
    $site = $this->getTargetSite();

    // If we have a specific site, we can remove all siteIds
    if ($result && $site) {
      foreach ($result as $index => $reference) {
        $result[$index]['siteId'] = null;
      }

    // If we now the target element, we remove the local site id
    } elseif ($result && $element) {
      foreach ($result as $index => $value) {
        if ($value['siteId'] == $element->siteId) {
          $result[$index]['siteId'] = null;
        }
      }
    }

    return $result;
  }

  /**
   * @return bool|string
   * @throws SiteNotFoundException
   */
  public function getShowSiteMenu(): bool|string {
    if (!is_null($this->getTargetSite())) {
      return false;
    }

    return $this->showSiteMenu;
  }

  /**
   * @return Site|null
   * @throws SiteNotFoundException
   */
  public function getTargetSite(): ?Site {
    if (empty($this->targetSite) || !Craft::$app->getIsMultiSite()) {
      return null;
    }

    $sites = Craft::$app->getSites();
    if (is_numeric($this->targetSite)) {
      return $sites->getSiteById($this->targetSite);
    } elseif (StringHelper::isUUID($this->targetSite)) {
      return $sites->getSiteByUid($this->targetSite);
    } else {
      return $sites->getSiteByHandle($this->targetSite);
    }
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
      ['viewMode', 'in', 'range' => ['cards', 'grid', 'large', 'list']]
    ]);
  }

  /**
   * Validates the elementType attribute.
   *
   * @param string $attribute
   * @internal
   * @noinspection PhpUnused (Validator)
   */
  public function validateElementType(string $attribute): void {
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

    if (!isset($criteria['siteId'])) {
      $target = $this->getTargetSite();
      if (!is_null($target)) {
        $criteria['siteId'] = $target->id;
      } elseif (!($element instanceof Element)) {
        $criteria['siteId'] = Craft::$app->getSites()->getCurrentSite()->id;
      } else {
        $criteria['siteId'] = $element->siteId;
      }
    }

    return $criteria;
  }

  /**
   * @return integer|null
   */
  private function getLimit(): ?int {
    return $this->limit;
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
  static public function expandFieldConfig(array &$config): void {
    // Expand the type `instances` to an array of instance fields
    if (in_array($config['type'], ['image', 'images'])) {
      $config = array_merge(
        [
          'criteria' => [ 'kind' => 'image' ],
          'limit' => $config['type'] == 'image' ? 1 : null,
        ],
        $config,
        [
          'type' => self::NAME,
          'elementType' => Asset::class,
        ]
      );
    }

    if (in_array($config['type'], ['asset', 'assets', 'file', 'files'])) {
      $config = array_merge(
        [
          'limit' => in_array($config['type'], ['asset', 'file']) ? 1 : null,
          'viewMode' => 'list'
        ],
        $config,
        [
          'type' => self::NAME,
          'elementType' => Asset::class,
        ]
      );
    }

    if (in_array($config['type'], ['category', 'categories'])) {
      $config = array_merge(
        [
          'limit' => $config['type'] == 'category' ? 1 : null,
          'viewMode' => 'list'
        ],
        $config,
        [
          'type' => self::NAME,
          'elementType' => Category::class,
        ]
      );
    }

    if (in_array($config['type'], ['entry', 'entries'])) {
      $config = array_merge(
        [
          'limit' => $config['type'] == 'entry' ? 1 : null,
          'viewMode' => 'list'
        ],
        $config,
        [
          'type' => self::NAME,
          'elementType' => Entry::class,
        ]
      );
    }
  }

  /**
   * Ensures the given element type is the class name of
   * a Craft element class.
   *
   * @param string $elementType
   * @return string|null
   */
  static public function resolveElementType(string $elementType): ?string {
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
   * @param string|string[]|null $rawValue
   * @param ElementInterface|null $element
   * @return string[]|null
   */
  static private function extractSources(array|string|null $rawValue, ElementInterface $element = null): ?array {
    $sources = self::parseSources($rawValue);

    try {
      $site = $element instanceof Element ? $element->getSite()->handle : '*';
    } catch (InvalidConfigException) {
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
   * @param string|array|null $rawValue
   * @return array<string, string[]>
   */
  static private function parseSources(array|string|null $rawValue): array {
    if (!is_array($rawValue)) {
      return [
        '*' => self::splitSourcesString($rawValue)
      ];
    }

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

  /**
   * @param string $rawValue
   * @return string[]
   */
  static private function splitSourcesString(string $rawValue): array {
    if (empty($rawValue)) {
      return [];
    }

    return array_filter(array_map(
      fn($value) => trim($value),
      explode(',', $rawValue)
    ));
  }
}
