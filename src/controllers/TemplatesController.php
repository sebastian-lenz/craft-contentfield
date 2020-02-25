<?php

namespace lenz\contentfield\controllers;

use Craft;
use craft\controllers\TemplatesController as BaseTemplatesController;
use lenz\contentfield\models\Content;
use Throwable;
use yii\web\Response as YiiResponse;

/**
 * Class TemplatesController
 */
class TemplatesController extends BaseTemplatesController
{
  /**
   * @var Content
   */
  public $content;

  /**
   * @var string
   */
  public $mimeType = 'text/html';


  /**
   * @inheritDoc
   * @throws Throwable
   */
  public function renderTemplate(string $template, array $variables = [], string $templateMode = null): YiiResponse {
    $response = Craft::$app->getResponse();
    if (!($response instanceof YiiResponse)) {
      $response = new YiiResponse();
    }

    $headers  = $response->getHeaders();
    if (!$headers->has('content-type')) {
      $headers->set('content-type', $this->mimeType . '; charset=' . $response->charset);
    }

    $response->data = $this->content->render($variables, [
      'view' => $this->view
    ]);

    // Must be set after the template is rendered so Yii creates nice error responses
    $response->format = YiiResponse::FORMAT_RAW;

    return $response;
  }
}
