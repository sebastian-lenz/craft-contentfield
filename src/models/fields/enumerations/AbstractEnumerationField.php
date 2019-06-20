<?php

namespace lenz\contentfield\models\fields\enumerations;

use Craft;
use Exception;
use lenz\contentfield\models\enumerations\EnumerationInterface;
use lenz\contentfield\models\enumerations\StaticEnumeration;
use lenz\contentfield\models\fields\AbstractField;
use lenz\contentfield\models\schemas\AbstractSchema;
use lenz\contentfield\models\values\ValueInterface;
use lenz\contentfield\models\values\EnumerationValue;
use craft\base\ElementInterface;
use Throwable;

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
   * @param AbstractSchema $schema
   * @param array $config
   * @throws Exception
   */
  public function __construct(AbstractSchema $schema, array $config = []) {
    if (isset($config['options'])) {
      $this->_enumeration = new StaticEnumeration($config['options']);
      unset($config['options']);
    }

    if (isset($config['enumeration'])) {
      try {
        if (is_array($config['enumeration'])) {
          $enumClass = $config['enumeration']['type'];
          $enumOptions = $config['enumeration'];
        } else {
          $enumClass = (string)$config['enumeration'];
          $enumOptions = [];
        }

        $enum = new $enumClass($enumOptions);
        if (!($enum instanceof EnumerationInterface)) {
          throw new Exception(sprintf('Invalid enumeration class given, %s must implement EnumerationInterface.', $enumClass));
        } else {
          $this->_enumeration = $enum;
        }
      } catch (Throwable $error) {
        Craft::warning($error->getMessage());
      }

      unset($config['enumeration']);
    }

    if (!isset($this->_enumeration)) {
      $this->_enumeration = new StaticEnumeration();
    }

    parent::__construct($schema, $config);
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
    $options = array_map(function($option) {
      return array_intersect_key($option, self::ALLOWED_OPTION_KEYS);
    }, $this->_enumeration->getOptions());

    return parent::getEditorData($element) + array(
      'defaultValue' => $this->defaultValue,
      'options'      => $options,
    );
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
    return $this->_enumeration;
  }
}
