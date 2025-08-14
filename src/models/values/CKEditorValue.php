<?php

namespace lenz\contentfield\models\values;

use craft\ckeditor\data\FieldData;
use lenz\contentfield\models\fields\AbstractField;
use Twig\Markup;

/**
 * Class CKEditorValue
 */
class CKEditorValue extends FieldData implements ValueInterface
{
  use ValueTrait;

  /**
   * @var Markup[]|null
   */
  private ?array $_pages;


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
   * Returns a specific page.
   *
   * @param int $pageNumber
   * @return Markup|null
   */
  public function getPage(int $pageNumber): ?Markup {
    $pages = $this->getPages();

    if (isset($pages[$pageNumber - 1])) {
      return $pages[$pageNumber - 1];
    }

    return null;
  }

  /**
   * @return Markup[]
   */
  public function getPages(): array {
    if (isset($this->_pages)) {
      return $this->_pages;
    }

    $pages = preg_split(
      '/(<div.*?class="page-break".*?>.*?<\\/div>|<!--pagebreak-->)/',
      $this->getParsedContent()
    );

    $this->_pages = [];
    foreach ($pages as $page) {
      $this->_pages[] = new Markup($page, \Craft::$app->charset);
    }

    return $this->_pages;
  }

  /**
   * @return int
   */
  public function getTotalPages(): int {
    return count($this->getPages());
  }

  /**
   * @return bool
   */
  public function isEmpty(): bool {
    return empty($this->rawContent);
  }
}
