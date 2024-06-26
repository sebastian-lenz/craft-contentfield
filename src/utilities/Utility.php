<?php

namespace lenz\contentfield\utilities;

use Craft;
use craft\base\Utility as UtilityBase;
use craft\helpers\Html;
use lenz\craft\utils\helpers\ArrayHelper;
use Throwable;

/**
 * Class Utility
 */
class Utility extends UtilityBase
{
  /**
   * @var AbstractPage
   */
  private AbstractPage $_current;

  /**
   * @var AbstractPage[]
   */
  private array $_pages;

  /**
   * @var Utility
   */
  private static Utility $_INSTANCE;


  /**
   * Utility constructor.
   *
   * @param array $config
   */
  public function __construct($config = []) {
    parent::__construct($config);

    $pages = [new IconPage(), new SourcesPage(), new ErrorsPage()];
    $handle = Craft::$app->getRequest()->getQueryParam('tab');
    $current = ArrayHelper::firstWhere($pages, fn($page) => $page->getHandle() == $handle);

    $this->_current = is_null($current) ? reset($pages) : $current;
    $this->_pages = $pages;
  }

  /**
   * @return string
   */
  public function getContentHtml(): string {
    try {
      return $this->_current->contentHtml();
    } catch (Throwable $error) {
      return $error->getMessage();
    }
  }

  /**
   * @return string
   */
  public function getToolbarHtml(): string {
    $buttons = implode('', array_map(function(AbstractPage $page) {
      return Html::tag('a', $page->getLabel(), [
        'class'     => 'btn' . ($page == $this->_current ? ' active' : ''),
        'href'      => $page->getUrl(),
        'data-icon' => $page->getIcon(),
      ]);
    }, $this->_pages));

    return $buttons . '<span style="flex:1;"></span>';
  }


  // Static methods
  // --------------

  /**
   * @inheritdoc
   */
  public static function contentHtml(): string {
    return self::getInstance()->getContentHtml();
  }

  /**
   * @inheritdoc
   */
  public static function displayName(): string {
    return Craft::t('contentfield', 'Content field utilities');
  }

  /**
   * @return Utility
   */
  public static function getInstance(): Utility {
    if (!isset(self::$_INSTANCE)) {
      self::$_INSTANCE = new Utility();
    }

    return self::$_INSTANCE;
  }

  /**
   * @inheritdoc
   */
  public static function iconPath(): ?string {
    return dirname(__DIR__) . '/icon-mono.svg';
  }

  /**
   * @inheritdoc
   */
  public static function id(): string {
    return 'tcf-utilities';
  }

  /**
   * @inheritDoc
   */
  public static function toolbarHtml(): string {
    return self::getInstance()->getToolbarHtml();
  }
}
