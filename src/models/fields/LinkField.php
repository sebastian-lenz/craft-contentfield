<?php

namespace lenz\contentfield\models\fields;

use Craft;
use craft\base\Element;
use craft\base\ElementInterface;
use Exception;
use lenz\contentfield\models\values\ValueInterface;
use lenz\contentfield\models\values\LinkValue;
use craft\elements\Asset;
use craft\elements\Entry;
use lenz\contentfield\utilities\ReferenceMap;

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
      'elementType' => Entry::class,
      'label'       => 'Entry',
      'sources'     => null,
      'type'        => 'element',
    ],
    'asset' => [
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

        $linkType['elementType'] = $elementType;
        $linkType['criteria'] = $criteria;
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
      'openInNewWindow' => $value->openInNewWindow,
      'type'            => $value->type,
      'url'             => $value->url,
    );
  }
}
