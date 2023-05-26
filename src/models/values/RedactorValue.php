<?php

namespace lenz\contentfield\models\values;

use Craft;
use lenz\contentfield\helpers\redactor\AbstractTokenizer;
use lenz\contentfield\helpers\ReferenceMap;
use lenz\contentfield\helpers\ReferenceMappableInterface;
use lenz\contentfield\models\fields\RedactorField;
use lenz\contentfield\twig\DisplayInterface;
use Twig\Markup;

/**
 * Class RedactorValue
 *
 * @property RedactorField $_field
 */
class RedactorValue
  extends Markup
  implements DisplayInterface, ReferenceMappableInterface, ValueInterface
{
  use ValueTrait;

  /**
   * @var Markup[]|null
   */
  private ?array $_pages = null;

  /**
   * @var AbstractTokenizer
   */
  private AbstractTokenizer $_tokenizer;

  /**
   * @var bool
   */
  static public bool $forceNativeRefParse = false;


  /**
   * RedactorValue constructor.
   *
   * @param mixed $data
   * @param ValueInterface|null $parent
   * @param RedactorField|null $field
   */
  public function __construct($data, ValueInterface $parent = null, RedactorField $field = null) {
    parent::__construct('', 'utf-8');

    $this->_field = $field;
    $this->_parent = $parent;
    $this->_tokenizer = AbstractTokenizer::create($this, is_string($data) ? $data : '', self::$forceNativeRefParse);
  }

  /**
   * @inheritdoc
   */
  public function __toString(): string {
    return $this->_tokenizer->getCompiledContent();
  }

  /**
   * @inheritDoc
   */
  public function count(): int {
    return mb_strlen($this->_tokenizer->getCompiledContent(), 'utf-8');
  }

  /**
   * @inheritDoc
   */
  public function display(array $variables = []): void {
    echo $this->_tokenizer->getCompiledContent();
  }

  /**
   * @inheritdoc
   */
  public function getHtml(): Markup {
    return new Markup($this->_tokenizer->getCompiledContent(), Craft::$app->charset);
  }

  /**
   * @return Markup[]
   */
  public function getPages(): array {
    if ($this->_pages !== null) {
      return $this->_pages;
    }

    $this->_pages = [];
    $pages = explode('<!--pagebreak-->', $this->_tokenizer->getCompiledContent());

    foreach ($pages as $page) {
      $this->_pages[] = new Markup($page, Craft::$app->charset);
    }

    return $this->_pages;
  }

  /**
   * @param int $pageNumber
   * @return Markup|null
   * @noinspection PhpUnused
   */
  public function getPage(int $pageNumber): ?Markup {
    $pages = $this->getPages();

    if (isset($pages[$pageNumber - 1])) {
      return $pages[$pageNumber - 1];
    }

    return null;
  }

  /**
   * Required for compatibility with craft\redactor\Field::serializeValue
   *
   * @return string
   * @internal
   */
  public function getRawContent(): string {
    return $this->_tokenizer->getRawContent();
  }

  /**
   * @inheritDoc
   * @internal
   */
  public function getReferenceMap(ReferenceMap $map = null): ReferenceMap {
    return $this->_tokenizer->registerReferences(
      is_null($map) ? new ReferenceMap() : $map
    );
  }

  /**
   * @return int
   * @noinspection PhpUnused (Public API)
   */
  public function getTotalPages(): int {
    return count($this->getPages());
  }

  /**
   * @return bool
   */
  public function isEmpty(): bool {
    return $this->_tokenizer->isEmpty();
  }

  /**
   * @inheritDoc
   */
  public function jsonSerialize(): ?string {
    return $this->_tokenizer->getCompiledContent();
  }
}
