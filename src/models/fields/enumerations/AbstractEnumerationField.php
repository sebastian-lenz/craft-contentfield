<?php

namespace lenz\contentfield\models\fields\enumerations;

use lenz\contentfield\models\enumerations\EnumerationInterface;
use lenz\contentfield\models\enumerations\StaticEnumeration;
use lenz\contentfield\models\fields\AbstractField;
use lenz\contentfield\models\values\ValueInterface;
use lenz\contentfield\models\values\EnumerationValue;
use craft\base\ElementInterface;

/**
 * Class AbstractEnumField
 */
abstract class AbstractEnumerationField extends AbstractField
{
  /**
   * @var EnumerationInterface
   */
  protected $enumeration;


  /**
   * AbstractEnumField constructor.
   *
   * @param array $config
   * @throws \Exception
   */
  public function __construct(array $config = []) {
    if (isset($config['options'])) {
      $this->enumeration = new StaticEnumeration($config['options']);
      unset($config['options']);
    }

    if (isset($config['enumeration'])) {
      try {
        $enumClass = $config['enumeration'];
        $enum = new $enumClass();

        if (!($enum instanceof EnumerationInterface)) {
          throw new \Exception(sprintf('Invalid enumeration class given, %s must implement EnumerationInterface.', $enumClass));
        } else {
          $this->enumeration = $enum;
        }
      } catch (\Throwable $error) {
        \Craft::warning($error->getMessage());
      }

      unset($config['enumeration']);
    }

    if (!isset($this->enumeration)) {
      $this->enumeration = new StaticEnumeration();
    }

    parent::__construct($config);
  }

  /**
   * @inheritdoc
   */
  public function createValue($data, ValueInterface $parent) {
    return new EnumerationValue($data, $parent, $this);
  }

  /**
   * @param ElementInterface|null $element
   * @return array
   */
  public function getEditorData(ElementInterface $element = null) {
    return parent::getEditorData($element) + array(
      'options' => $this->enumeration->getOptions()
    );
  }

  /**
   * @return EnumerationInterface
   */
  public function getEnumeration() {
    return $this->enumeration;
  }
}
