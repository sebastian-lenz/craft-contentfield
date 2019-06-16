<?php

namespace lenz\contentfield\controllers;

use Craft;
use craft\controllers\TemplatesController as BaseTemplatesController;
use Exception;
use lenz\contentfield\models\Content;
use lenz\contentfield\models\schemas\TemplateSchema;
use yii\web\Response;
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
   * Renders a template.
   *
   * @param string $template
   * @param array $variables
   * @return Response
   * @throws Exception
   */
  public function actionRender(string $template, array $variables = []): Response {
    $routeParams = Craft::$app->getUrlManager()->getRouteParams();
    unset($routeParams['template']);

    $variables = array_merge($variables, $routeParams);
    $response  = Craft::$app->getResponse();
    $headers   = $response->getHeaders();

    if (!$headers->has('content-type')) {
      $headers->set('content-type', $this->mimeType . '; charset=' . $response->charset);
    }

    $response->format  = YiiResponse::FORMAT_RAW;
    $response->content = $this->content->render($variables, [
      'view' => $this->view
    ]);

    return $response;
  }
}
