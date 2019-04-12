<?php

namespace sebastianlenz\contentfield\models\values;

use sebastianlenz\contentfield\models\fields\OEmbedField;
use sebastianlenz\contentfield\utilities\oembed\OEmbed;

/**
 * Class OEmbedValue
 *
 * @property OEmbedField $__field
 */
class OEmbedValue extends AbstractValue
{
  /**
   * @var string
   */
  private $_value = '';


  /**
   * StringValue constructor.
   *
   * @param mixed $data
   * @param AbstractValue $parent
   * @param OEmbedField $field
   */
  public function __construct($data, AbstractValue $parent, OEmbedField $field) {
    parent::__construct($parent, $field);

    if (is_array($data) && array_key_exists('url', $data)) {
      $this->_value = (string)$data['url'];
    } elseif (is_string($data)) {
      $this->_value = $data;
    }
  }

  /**
   * @inheritdoc
   */
  public function __toString() {
    return $this->_value;
  }

  /**
   * @inheritdoc
   */
  public function getEditorData() {
    return array(
      'url'  => $this->_value,
      'info' => $this->getOEmbed(),
    );
  }

  /**
   * @inheritdoc
   */
  public function getHtml($options = null) {
    $oembed = $this->getOEmbed();
    return new \Twig_Markup(is_null($oembed)
      ? ''
      : $oembed->getHtml($options)
    , 'utf-8');
  }

  /**
   * @return OEmbed|null
   */
  public function getOEmbed() {
    return $this->__field->getOEmbed($this->_value);
  }

  /**
   * @return mixed
   */
  public function getSerializedData() {
    return $this->_value;
  }

  /**
   * @return bool
   */
  public function isEmpty() {
    return is_null($this->getOEmbed());
  }
}
