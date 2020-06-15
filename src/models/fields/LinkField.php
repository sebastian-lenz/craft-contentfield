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
  public $allowNewWindow = true;

  /**
   * @var array
   */
  public $linkTypes = [
    'url' => [
      'inputType'   => 'url',
      'label'       => 'Url',
      'type'        => 'input',
    ],
    'mail' => [
      'inputType'   => 'email',
      'label'       => 'E-Mail',
      'type'        => 'input',
    ],
    'entry' => [
      'allowHash'   => false,
      'elementType' => Entry::class,
      'label'       => 'Entry',
      'sources'     => null,
      'type'        => 'element',
    ],
    'asset' => [
      'allowHash'   => false,
      'elementType' => Asset::class,
      'label'       => 'Asset',
      'sources'     => null,
      'type'        => 'element',
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
  public function createValue($data, ValueInterface $parent = null) {
    return new LinkValue($data, $parent, $this);
  }

  /**
   * @inheritdoc
   * @throws Exception
   */
  public function getEditorData(ElementInterface $element = null) {
    $linkTypes = $this->linkTypes;
    foreach ($linkTypes as $key => &$linkType) {
      if (isset($linkType['elementType'])) {
        $elementType = ReferenceMap::normalizeElementType($linkType['elementType']);
        $criteria = isset($linkType['criteria']) && is_array($linkType['criteria'])
          ? $linkType['criteria']
          : [];

        if (is_null($element) || !($element instanceof Element)) {
          $criteria['siteId'] = Craft::$app->getSites()->getCurrentSite()->id;
        } else {
          $criteria['siteId'] = $element->siteId;
        }

        $linkType['allowHash'] = isset($linkType['allowHash'])
          ? !!$linkType['allowHash']
          : false;

        $linkType['criteria'] = $criteria;
        $linkType['elementType'] = $elementType;
      }
    }

    return parent::getEditorData($element) + array(
      'allowNewWindow' => $this->allowNewWindow,
      'linkTypes'      => $linkTypes,
    );
  }

  /**
   * @inheritDoc
   */
  public function getEditorValue($value) {
    if (!($value instanceof LinkValue)) {
      return null;
    }

    return array(
      'elementId'       => $value->elementId,
      'hash'            => $value->hash,
      'openInNewWindow' => $value->openInNewWindow,
      'type'            => $value->type,
      'url'             => $value->url,
    );
  }

  /**
   * @inheritDoc
   */
  public function rules() {
    return array_merge(parent::rules(), [
      ['allowNewWindow', 'boolean'],
      ['linkTypes', 'validateLinkTypes'],
      [['allowNewWindow', 'linkTypes'], 'required'],
    ]);
  }

  /**
   * @param string $attribute
   * @return void
   */
  public function validateLinkTypes($attribute) {
    $value = $this->$attribute;
    if (!is_array($value)) {
      return $this->addError($attribute, "$attribute must be an array");
    }

    foreach ($value as $name => $data) {
      $this->validateLinkType(function($message) use ($name, $attribute) {
        $this->addError($attribute, "Link type `$name`: $message");
      }, $data);
    }
  }


  // Protected methods
  // -----------------

  /**
   * @param callable $callback
   * @param mixed $info
   * @return void
   */
  protected function validateLinkType(callable $callback, $info) {
    if (!is_array($info)) {
      return $callback("Definition must be an array");
    }

    // Validate label
    if (!array_key_exists('label', $info)) {
      return $callback("Property `label` is missing");
    }

    if (!is_string($info['label'])) {
      return $callback("Property `label` must be a string");
    }

    // Validate type
    if (!array_key_exists('type', $info)) {
      return $callback("Property `type` is missing");
    }

    $type = $info['type'];
    if (!in_array($type, self::LINK_TYPES)) {
      return $callback("The type `{$type}` is invalid.");
    }

    // Validate element type
    if ($type == 'element') {
      $elementType = ReferenceMap::normalizeElementType($info['elementType']);
      if (!class_exists($elementType)) {
        return $callback("The element type `{$elementType}` is invalid.");
      }
    }
  }
}
