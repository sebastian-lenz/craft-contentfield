<?php

namespace contentfield\models\fields;

use craft\base\ElementInterface;

use contentfield\models\values\AbstractValue;
use contentfield\models\values\LinkValue;
use craft\elements\Entry;

/**
 * Class LinkField
 */
class LinkField extends AbstractField
{
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
  ];

  /**
   * @inheritdoc
   */
  const NAME = 'link';


  /**
   * @inheritdoc
   */
  public function createValue($data, AbstractValue $parent) {
    return new LinkValue($data, $parent, $this);
  }

  /**
   * @inheritdoc
   */
  public function getEditorData(ElementInterface $element = null) {
    return parent::getEditorData($element) + array(
      'linkTypes' => $this->linkTypes
    );
  }
}
