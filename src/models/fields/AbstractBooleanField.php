<?php

namespace lenz\contentfield\models\fields;

use craft\base\ElementInterface;
use lenz\contentfield\models\values\ValueInterface;

/**
 * Class AbstractBooleanField
 */
abstract class AbstractBooleanField extends AbstractField
{
  /**
   * @var boolean
   */
  public bool $defaultValue = false;


  /**
   * @inheritdoc
   */
  public function createValue(mixed $data, ValueInterface $parent = null): bool {
    return !!$data;
  }

  /**
   * @inheritdoc
   */
  public function getEditorData(ElementInterface $element = null): array {
    return parent::getEditorData($element) + array(
      'defaultValue' => !!$this->defaultValue
    );
  }

  /**
   * @inheritDoc
   */
  public function getEditorValue(mixed $value): bool {
    return !!$value;
  }

  /**
   * @inheritDoc
   */
  public function useRawValueValidation(): bool {
    return true;
  }
}
