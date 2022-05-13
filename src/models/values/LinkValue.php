<?php

namespace lenz\contentfield\models\values;

use Craft;
use craft\base\ElementInterface;
use Exception;
use lenz\contentfield\helpers\ReferenceMap;
use lenz\contentfield\helpers\ReferenceMappableInterface;
use lenz\contentfield\models\fields\LinkField;
use lenz\craft\utils\events\AnchorEvent;
use lenz\craft\utils\models\Attributes;

/**
 * Class LinkValue
 *
 * @property LinkField $_field
 */
class LinkValue extends AbstractValue implements ReferenceMappableInterface
{
  /**
   * @var bool
   */
  public bool $autoNoReferrer = true;

  /**
   * @var int
   */
  public int $elementId = 0;

  /**
   * @var string
   */
  public string $hash = '';

  /**
   * @var bool
   */
  public bool $openInNewWindow = false;

  /**
   * @var string
   */
  public string $type = '';

  /**
   * @var string
   */
  public string $url = '';

  /**
   * @var ElementInterface|null
   */
  private ?ElementInterface $_element;


  /**
   * LinkValue constructor.
   *
   * @param mixed $data
   * @param ValueInterface|null $parent
   * @param LinkField|null $field
   */
  public function __construct($data, ValueInterface $parent = null, LinkField $field = null) {
    parent::__construct($parent, $field);

    if (is_array($data)) {
      if (isset($data['autoNoReferrer'])) {
        $this->autoNoReferrer = !!$data['autoNoReferrer'];
      }

      if (isset($data['elementId']) && is_numeric($data['elementId'])) {
        $this->elementId = $data['elementId'];
      }

      if (isset($data['hash'])) {
        $this->hash = trim($data['hash']);
      }

      if (isset($data['type'])) {
        $this->type = $data['type'];
      }

      if (isset($data['url'])) {
        $this->url = trim($data['url']);
      }

      if (isset($data['openInNewWindow'])) {
        $this->openInNewWindow = !!$data['openInNewWindow'];
      }
    }
  }

  /**
   * @return string
   * @throws Exception
   */
  public function __toString(): string {
    return $this->getUrl();
  }

  /**
   * @return null|string
   */
  public function getElementType(): ?string {
    $linkType = $this->getLinkType();

    return !is_null($linkType) && $linkType['type'] === 'element'
      ? ReferenceMap::normalizeElementType($linkType['elementType'])
      : null;
  }

  /**
   * @param array $extraAttribs
   * @return Attributes
   * @throws Exception
   * @noinspection PhpUnused (Public API)
   */
  public function getLinkAttributes(array $extraAttribs = []): Attributes {
    $attr = new Attributes($extraAttribs);
    if ($this->isEmpty()) {
      return $attr;
    }

    if ($this->openInNewWindow) {
      $attr->set('target', '_blank');

      if ($this->autoNoReferrer) {
        $attr->set('rel', 'noopener noreferrer');
      }
    }

    $attr->set('href', $this->getUrl());
    return $attr;
  }

  /**
   * @return ElementInterface|null
   * @throws Exception
   */
  public function getLinkedElement(): ?ElementInterface {
    if (!isset($this->_element)) {
      if (!$this->hasLinkedElement()) {
        $this->_element = null;
      } else {
        $elementType = $this->getElementType();
        $elementId = $this->elementId;
        $content = $this->getContent();

        if (!is_null($content)) {
          $this->_element = $content
            ->getReferenceLoader()
            ->getElement($elementType, $elementId);
        } else {
          /** @var ElementInterface $elementType */
          $this->_element = $elementType::findOne([
            'id' => $elementId,
          ]);
        }
      }
    }

    return $this->_element;
  }

  /**
   * @return array|null
   */
  public function getLinkType(): ?array {
    return array_key_exists($this->type, $this->_field->linkTypes)
      ? $this->_field->linkTypes[$this->type]
      : null;
  }

  /**
   * @inheritdoc
   */
  public function getReferenceMap(ReferenceMap $map = null): ReferenceMap {
    $map = is_null($map) ? new ReferenceMap() : $map;
    if ($this->hasLinkedElement()) {
      $map->push($this->getElementType(), $this->elementId);
    }

    return $map;
  }

  /**
   * @return string
   */
  public function getUrl(): string {
    $linkType = $this->getLinkType();
    $inputType = is_array($linkType) && array_key_exists('inputType', $linkType)
      ? $linkType['inputType']
      : '';

    return match ($inputType) {
      'url' => $this->getInputUrl(),
      'email', 'mail' => $this->getMailUrl(),
      default => $this->getElementUrl(),
    };
  }

  /**
   * @return bool
   */
  public function hasLinkedElement(): bool {
    $elementType = $this->getElementType();

    return (
      !is_null($elementType) &&
      $this->elementId !== 0
    );
  }

  /**
   * @return bool
   * @throws Exception
   */
  public function isEmpty(): bool {
    $linkType = $this->getLinkType();
    if (is_null($linkType)) {
      return true;
    }

    return $linkType['type'] === 'element'
      ? is_null($this->getLinkedElement())
      : empty($this->url);
  }


  // Private methods
  // ---------------

  /**
   * @return string
   */
  private function getElementUrl(): string {
    try {
      $element = $this->getLinkedElement();
    } catch (Exception) {
      return '';
    }

    if (is_null($element)) {
      return '';
    }

    $url = $element->getUrl();
    if (empty($url) || !is_string($url)) {
      return '';
    }

    if (!empty($this->hash)) {
      $url .= '#' . AnchorEvent::resolveAnchor($this->hash, $element);
    }

    return $url;
  }

  /**
   * @return string
   */
  private function getInputUrl(): string {
    $url = $this->url;
    if (empty($url)) {
      $url = '';
    } elseif ($this->_field->allowAliases) {
      $url = Craft::getAlias($url);
    }

    if (!empty($this->hash)) {
      $hashOffset = strpos($url, '#');
      if ($hashOffset !== -1) {
        $url = substr($url, 0, $hashOffset);
      }

      $url .= '#' . $this->hash;
    }

    return $url;
  }

  /**
   * @return string
   */
  private function getMailUrl(): string {
    $url = $this->url;
    return empty($url)
      ? ''
      : 'mailto:' . $url;
  }
}
