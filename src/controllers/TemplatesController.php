<?php

namespace lenz\contentfield\controllers;

use Craft;
use craft\controllers\TemplatesController as BaseTemplatesController;
use lenz\contentfield\models\Content;
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
   * @throws \Throwable
   */
  public function renderTemplate(string $template, array $variables = []): YiiResponse {
    $response = Craft::$app->getResponse();
    $headers  = $response->getHeaders();

    if (!$headers->has('content-type')) {
      $headers->set('content-type', $this->mimeType . '; charset=' . $response->charset);
    }

    $response->format = YiiResponse::FORMAT_RAW;
    $response->data = $this->content->render($variables, [
      'view' => $this->view
    ]);

    return $response;
  }
}
