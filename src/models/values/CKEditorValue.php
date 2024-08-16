<?php

namespace lenz\contentfield\models\values;

use craft\ckeditor\data\FieldData;
use lenz\contentfield\models\fields\AbstractField;

/**
 * Class CKEditorValue
 */
class CKEditorValue extends FieldData implements ValueInterface
{
  use ValueTrait;

  /**
   * CKEditorValue constructor.
   *
   * @param string $content
   * @param int|null $siteId
   * @param ValueInterface|null $parent
   * @param AbstractField|null $field
   */
  public function __construct(string $content, ?int $siteId = null, ValueInterface $parent = null, AbstractField $field = null) {
    parent::__construct($content, $siteId);

    $this->_field = $field;
    $this->_parent = $parent;
  }

  /**
   * @inheritDoc
   */
  public function isEmpty(): bool {
    return empty($this->rawContent);
  }
}
