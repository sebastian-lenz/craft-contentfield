<?php

namespace lenz\contentfield\utilities;

use Craft;
use lenz\contentfield\Plugin;

/**
 * Class ErrorsPage
 */
class ErrorsPage extends AbstractPage
{
  /**
   * @inheritDoc
   */
  public function contentHtml() : string {
    $view = Craft::$app->getView();

    return $view->renderTemplate('contentfield/_utility-errors', [
      'errors' => Plugin::getInstance()->schemas->getAllErrors(),
    ]);
  }

  /**
   * @inheritDoc
   */
  public function getHandle() : string {
    return 'errors';
  }

  /**
   * @inheritDoc
   */
  public function getIcon(): string {
    return 'error';
  }

  /**
   * @inheritDoc
   */
  public function getLabel() : string {
    return 'Errors';
  }
}
