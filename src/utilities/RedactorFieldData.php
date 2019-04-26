<?php

namespace lenz\contentfield\utilities;

use Craft;

/**
 * Class RedactorFieldData
 */
class RedactorFieldData extends \Twig_Markup
{
  /**
   * @var
   */
  private $_pages;
  

  /**
   * Constructor
   * @param string $content
   */
  public function __construct(string $content) {
    parent::__construct($content, Craft::$app->charset);
  }

  /**
   * @return string
   */
  public function getParsedContent(): string {
    return (string)$this;
  }

  /**
   * @return \Twig_Markup[]
   */
  public function getPages(): array {
    if ($this->_pages !== null) {
      return $this->_pages;
    }

    $this->_pages = [];
    $pages = explode('<!--pagebreak-->', (string)$this);

    foreach ($pages as $page) {
      $this->_pages[] = new \Twig_Markup($page, Craft::$app->charset);
    }

    return $this->_pages;
  }

  /**
   * @param int $pageNumber
   * @return string|null
   */
  public function getPage(int $pageNumber) {
    $pages = $this->getPages();

    if (isset($pages[$pageNumber - 1])) {
      return $pages[$pageNumber - 1];
    }

    return null;
  }

  /**
   * @return int
   */
  public function getTotalPages(): int {
    return count($this->getPages());
  }
}
