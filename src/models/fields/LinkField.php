<?php

namespace lenz\contentfield\models\fields;

use Craft;
use craft\base\Element;
use craft\base\ElementInterface;
use craft\elements\Asset;
use craft\elements\Entry;
use Exception;
use lenz\contentfield\helpers\ReferenceMap;
use lenz\contentfield\models\values\LinkValue;
use lenz\contentfield\models\values\ValueInterface;

/**
 * Class LinkField
 */
class LinkField extends AbstractField
{
  /**
   * @var bool
   */
  public bool $allowAliases = true;

  /**
   * @var bool
   */
  public bool $allowNewWindow = true;

  /**
   * @var array
   */
  public array $linkTypes = [
    'url' => [
      'inputType'    => 'url',
      'label'        => 'Url',
      'type'         => 'input',
    ],
    'mail' => [
      'inputType'    => 'email',
      'label'        => 'E-Mail',
      'type'         => 'input',
    ],
    'entry' => [
      'allowHash'    => false,
      'allowSelf'    => false,
      'elementType'  => Entry::class,
      'label'        => 'Entry',
      'showSiteMenu' => false,
      'sources'      => null,
      'type'         => 'element',
    ],
    'asset' => [
      'allowHash'    => false,
      'elementType'  => Asset::class,
      'label'        => 'Asset',
      'sources'      => null,
      'type'         => 'element',
    ],
  ];

  /**
   * @inheritdoc
   */
  const NAME = 'link';

  /**
   * @var array
   */
  const LINK_TYPES = ['input', 'element'];


  /**
   * @inheritdoc
   */
  public function createValue(mixed $data, ValueInterface $parent = null): LinkValue {
    return new LinkValue($data, $parent, $this);
  }

  /**
   * @inheritdoc
   * @throws Exception
   */
  public function getEditorData(ElementInterface $element = null): array {
    $linkTypes = $this->linkTypes;
    foreach ($linkTypes as &$linkType) {
      if (isset($linkType['elementType'])) {
        $elementType = ReferenceMap::normalizeElementType($linkType['elementType']);
        $criteria = isset($linkType['criteria']) && is_array($linkType['criteria'])
          ? $linkType['criteria']
          : [];

        if (!($element instanceof Element)) {
          $criteria['siteId'] = Craft::$app->getSites()->getCurrentSite()->id;
        } else {
          $criteria['siteId'] = $element->siteId;
        }

        if (isset($linkType['allowHash'])) {
          $linkType['allowHash'] = $linkType['allowHash'] == 'select'
            ? $linkType['allowHash']
            : !!$linkType['allowHash'];
        } else {
          $linkType['allowHash'] = false;
        }

        $linkType['criteria'] = $criteria;
        $linkType['elementType'] = $elementType;
      }
    }

    return parent::getEditorData($element) + [
      'allowNewWindow' => $this->allowNewWindow,
      'linkTypes'      => $linkTypes,
    ];
  }

  /**
   * @inheritDoc
   */
  public function getEditorValue(mixed $value): ?array {
    if (!($value instanceof LinkValue)) {
      return null;
    }

    $element = $value->getLinkedElement();
    return [
      'elementId'       => $element?->id,
      'hash'            => $value->hash,
      'openInNewWindow' => $value->openInNewWindow,
      'siteId'          => $element?->siteId,
      'type'            => $value->type,
      'url'             => $value->url,
    ];
  }

  /**
   * @inheritDoc
   */
  public function getSerializedValue(mixed $value, ElementInterface $element = null): ?array {
    $result = parent::getSerializedValue($value);
    if ($result && $element) {
      if ($result['siteId'] == $element->siteId) {
        $result['siteId'] = null;
      }
    }

    return $result;
  }

  /**
   * @inheritDoc
   */
  public function rules(): array {
    return array_merge(parent::rules(), [
      [['allowAliases', 'allowNewWindow'], 'boolean'],
      ['linkTypes', 'validateLinkTypes'],
      [['allowNewWindow', 'linkTypes'], 'required'],
    ]);
  }

  /**
   * @param string $attribute
   * @return void
   * @noinspection PhpUnused (Validator)
   */
  public function validateLinkTypes(string $attribute): void {
    $value = $this->$attribute;
    if (!is_array($value)) {
      $this->addError($attribute, "$attribute must be an array");
      return;
    }

    foreach ($value as $name => $data) {
      try {
        $this->validateLinkType($data);
      } catch (Exception $error) {
        $this->addError($attribute, "Link type `$name`: {$error->getMessage()}");
      }
    }
  }


  // Protected methods
  // -----------------

  /**
   * @param mixed $data
   * @return void
   * @throws Exception
   */
  protected function validateLinkType(mixed $data): void {
    if (!is_array($data)) {
      throw new Exception("Definition must be an array");
    }

    // Validate label
    if (!array_key_exists('label', $data)) {
      throw new Exception("Property `label` is missing");
    }

    if (!is_string($data['label'])) {
      throw new Exception("Property `label` must be a string");
    }

    // Validate type
    if (!array_key_exists('type', $data)) {
      throw new Exception("Property `type` is missing");
    }

    $type = $data['type'];
    if (!in_array($type, self::LINK_TYPES)) {
      throw new Exception("The type `$type` is invalid.");
    }

    // Validate element type
    if ($type == 'element') {
      if (array_key_exists('allowSelf', $data) && !is_bool($data['allowSelf'])) {
        throw new Exception("Property `allowSelf` must be boolean");
      }

      if (array_key_exists('showSiteMenu', $data) && !is_bool($data['showSiteMenu'])) {
        throw new Exception("Property `showSiteMenu` must be boolean");
      }

      $elementType = ReferenceMap::normalizeElementType($data['elementType']);
      if (!class_exists($elementType)) {
        throw new Exception("The element type `$elementType` is invalid.");
      }
    }
  }
}
