<?php

namespace lenz\contentfield\models\fields;

use craft\base\ElementInterface;
use Exception;
use lenz\contentfield\models\enumerations\EnumerationInterface;
use lenz\contentfield\models\enumerations\StaticEnumeration;
use lenz\contentfield\models\schemas\AbstractSchema;
use lenz\contentfield\models\values\EnumerationValue;
use lenz\contentfield\models\values\ValueInterface;

/**
 * Class AbstractEnumField
 */
abstract class AbstractEnumerationField extends AbstractField
{
  /**
   * @var string|int
   */
  public $defaultValue;

  /**
   * @var EnumerationInterface
   */
  protected $_enumeration;

  /**
   * Defines the keys of an option array.
   */
  const ALLOWED_OPTION_KEYS = [
    'indent' => true,
    'key'    => true,
    'label'  => true,
  ];


  /**
   * AbstractEnumField constructor.
   *
   * @param AbstractSchema|null $schema
   * @param array $config
   * @throws Exception
   */
  public function __construct(AbstractSchema $schema = null, array $config = []) {
    if (isset($config['options'])) {
      $this->_enumeration = new StaticEnumeration($config['options']);
      unset($config['options']);
    }

    if (isset($config['enumeration'])) {
      $this->_enumeration = $this->createEnumeration($config['enumeration']);
      unset($config['enumeration']);
    }

    parent::__construct($schema, $config);
  }

  /**
   * @inheritdoc
   */
  public function createValue($data, ValueInterface $parent = null) {
    return new EnumerationValue($data, $parent, $this);
  }

  /**
   * @param ElementInterface|null $element
   * @return array
   */
  public function getEditorData(ElementInterface $element = null): array {
    $options = array_map(function($option) {
      return array_intersect_key($option, self::ALLOWED_OPTION_KEYS);
    }, $this->getEnumeration()->getOptions());

    return parent::getEditorData($element) + [
      'defaultValue' => $this->defaultValue,
      'options'      => $options,
    ];
  }

  /**
   * @inheritDoc
   */
  public function getEditorValue($value) {
    if (!($value instanceof EnumerationValue)) {
      return null;
    }

    return $value->getValue();
  }

  /**
   * @return EnumerationInterface
   */
  public function getEnumeration() {
    if (!($this->_enumeration instanceof EnumerationInterface)) {
      $this->_enumeration = new StaticEnumeration();
    }

    return $this->_enumeration;
  }


  // Protected methods
  // -----------------

  /**
   * @param array|string $config
   * @return EnumerationInterface
   * @throws Exception
   */
  private function createEnumeration($config): EnumerationInterface {
    if (is_array($config)) {
      $enumClass = $config['type'];
      $enumOptions = $config;
    } else {
      $enumClass = (string)$config;
      $enumOptions = [];
    }

    $enum = new $enumClass($enumOptions);
    if (!($enum instanceof EnumerationInterface)) {
      throw new Exception(sprintf('Invalid enumeration class given, %s must implement EnumerationInterface.', $enumClass));
    }

    return $enum;
  }
}
