<?php

namespace lenz\contentfield\models\values;

use lenz\contentfield\models\fields\OEmbedField;
use lenz\contentfield\services\oembeds\OEmbed;
use lenz\contentfield\twig\DisplayInterface;
use Twig\Markup;

/**
 * Class OEmbedValue
 *
 * @property OEmbedField $_field
 */
class OEmbedValue extends AbstractValue implements DisplayInterface
{
  /**
   * @var string
   */
  private string $_url = '';


  /**
   * StringValue constructor.
   *
   * @param mixed $data
   * @param ValueInterface|null $parent
   * @param OEmbedField|null $field
   */
  public function __construct($data, ValueInterface $parent = null, OEmbedField $field = null) {
    parent::__construct($parent, $field);

    if (is_array($data) && array_key_exists('url', $data)) {
      $this->_url = (string)$data['url'];
    } elseif (is_string($data)) {
      $this->_url = $data;
    }
  }

  /**
   * @inheritdoc
   */
  public function __toString(): string {
    return $this->_url;
  }

  /**
   * @inheritDoc
   */
  public function display(array $variables = []): \Generator {
    $oEmbed = $this->getOEmbed();
    yield is_null($oEmbed)
      ? ''
      : $oEmbed->getHtml($variables);
  }

  /**
   * @inheritdoc
   */
  public function getHtml($options = null): Markup {
    $oEmbed = $this->getOEmbed();
    return new Markup(is_null($oEmbed)
      ? ''
      : $oEmbed->getHtml($options)
    , 'utf-8');
  }

  /**
   * @return OEmbed|null
   */
  public function getOEmbed(): ?OEmbed {
    return $this->_field->getOEmbed($this->_url);
  }

  /**
   * @return string
   */
  public function getUrl(): string {
    return $this->_url;
  }

  /**
   * @return bool
   */
  public function isEmpty(): bool {
    return is_null($this->getOEmbed());
  }
}
