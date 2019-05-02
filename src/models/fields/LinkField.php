<?php

namespace lenz\contentfield\models\fields;

use craft\base\ElementInterface;
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
  public function createValue($data, ValueInterface $parent) {
    return new LinkValue($data, $parent, $this);
  }

  /**
   * @inheritdoc
   */
  public function getEditorData(ElementInterface $element = null) {
    $linkTypes = $this->linkTypes;
    foreach ($linkTypes as $key => $linkType) {
      if (isset($linkType['elementType'])) {
        $linkTypes[$key]['elementType'] = ReferenceMap::normalizeElementType($linkType['elementType']);
      }
    }

    return parent::getEditorData($element) + array(
      'allowNewWindow' => $this->allowNewWindow,
      'linkTypes'      => $linkTypes,
    );
  }
}
