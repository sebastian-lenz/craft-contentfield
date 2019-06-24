<?php

namespace lenz\contentfield\controllers;

use Craft;
use craft\controllers\EntriesController as BaseEntriesController;
use craft\elements\Entry;
use Exception;
use lenz\contentfield\models\Content;
use Throwable;
use yii\web\Response as YiiResponse;

/**
 * Class TemplatesController
 */
class EntriesController extends BaseEntriesController
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
  public function renderTemplate(string $template, array $variables = []): YiiResponse {
    $response = Craft::$app->getResponse();
    $headers  = $response->getHeaders();
    $entry    = $variables['entry'];

    if (!($entry instanceof Entry)) {
      throw new Exception('Missing preview entry.');
    }

    $content = $entry->getFieldValue($this->content->getField()->handle);
    if (!($content instanceof Content)) {
      throw new Exception('Missing preview content.');
    }

    if (!$headers->has('content-type')) {
      $headers->set('content-type', $this->mimeType . '; charset=' . $response->charset);
    }

    $response->format = YiiResponse::FORMAT_RAW;
    $response->data = $content->render($variables, [
      'view' => $this->view
    ]);

    return $response;
  }
}
