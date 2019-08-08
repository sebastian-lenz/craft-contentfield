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
  public function contentHtml() {
    $view = Craft::$app->getView();

    return $view->renderTemplate('contentfield/_utility-errors', [
      'errors' => Plugin::getInstance()->schemas->getAllErrors(),
    ]);
  }

  /**
   * @inheritDoc
   */
  public function getHandle() {
    return 'errors';
  }

  /**
   * @inheritDoc
   */
  public function getLabel() {
    return 'Errors';
  }
}
