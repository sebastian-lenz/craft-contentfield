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
}
