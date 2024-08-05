<?php

namespace lenz\contentfield\controllers;

use Craft;
use craft\elements\Asset;
use craft\errors\InvalidFieldException;
use craft\helpers\HtmlPurifier;
use craft\web\Controller;
use Exception;
use lenz\contentfield\fields\content\InputData;
use lenz\contentfield\models\Content;
use lenz\contentfield\models\fields\OEmbedField;
use lenz\contentfield\Plugin;
use lenz\craft\utils\events\AnchorsEvent;
use yii\web\NotFoundHttpException;
use yii\web\Response;

/**
 * Class CpController
 * @noinspection PhpUnused
 */
class CpController extends Controller
{
  /**
   * @param string $siteId
   * @param string $elementId
   * @return Response
   * @noinspection PhpUnused
   */
  public function actionAnchors(string $siteId, string $elementId): Response {
    try {
      $anchors = AnchorsEvent::findAnchorsById($elementId, $siteId);
    } catch (Exception) {
      return $this->asJson([ 'result' => false ]);
    }

    return $this->asJson([
      'anchors' => $anchors,
      'result' => true,
    ]);
  }

  /**
   * @param string $siteId
   * @param string $elementId
   * @param string $fieldHandle
   * @return Response
   * @throws InvalidFieldException
   * @noinspection PhpUnused
   */
  public function actionFetch(string $siteId, string $elementId, string $fieldHandle): Response {
    $element = Craft::$app->elements->getElementById($elementId, null, $siteId);
    if (is_null($element)) {
      return $this->asJson([
        'result'  => false,
        'message' => 'Element not found.'
      ]);
    }

    $value = $element->getFieldValue($fieldHandle);
    if (!($value instanceof Content)) {
      return $this->asJson([
        'result'  => false,
        'message' => 'Target field is not a content field.'
      ]);
    }

    if (is_null($value->getModel())) {
      return $this->asJson([
        'result'  => false,
        'message' => 'The site contains no data.'
      ]);
    }

    return $this->asJson([
      'result'     => true,
      'data'       => $value->getEditorValue(),
      'references' => InputData::loadReferences($value),
    ]);
  }

  /**
   * @param int $id
   * @param int $siteId
   * @return Response
   * @throws NotFoundHttpException
   * @throws \yii\base\InvalidConfigException
   */
  public function actionHotspotAsset(int $id, int $siteId) {
    $asset = Asset::findOne(['id' => $id, 'siteId' => $siteId]);
    if (!$asset) {
      throw new NotFoundHttpException();
    }

    return $this->asJson([
      'height' => $asset->height,
      'width' => $asset->width,
      'editUrl' => $asset->getUrl([
        'height' => 1080,
        'mode' => 'fit',
        'width' => 1920,
      ]),
      'previewUrl' => $asset->getUrl([
        'height' => 240,
        'mode' => 'fit',
        'width' => 240,
      ])
    ]);
  }

  /**
   * @param string $schema
   * @param string $field
   * @param string $url
   * @return Response
   * @throws Exception
   * @noinspection PhpUnused
   */
  public function actionOembed(string $schema, string $field, string $url): Response {
    $instance = Plugin::getInstance()->schemas->getSchema($schema);
    if (is_null($instance)) {
      throw new Exception('Invalid schema provided: ' . $schema);
    }

    if (
      !array_key_exists($field, $instance->fields) ||
      !($instance->fields[$field] instanceof OEmbedField)
    ) {
      throw new Exception('Invalid field provided: ' . $field);
    }

    $oembedField = $instance->fields[$field];
    $oembed = $oembedField->getOEmbed($url);

    return $this->asJson(is_null($oembed) ? [
      'success' => false,
    ] : [
      'success' => true,
      'data' => $oembed,
    ]);
  }

  /**
   * @param int $id
   * @param int $siteId
   * @return Response
   */
  public function actionReference(int $id, int $siteId): Response {
    Craft::$app->getView()->setNamespace('pageContent');

    return $this->asJson(
      InputData::toReference(
        Craft::$app->getElements()->getElementById($id, null, $siteId)
      )
    );
  }

  /**
   * @return Response
   * @noinspection PhpUnused
   */
  public function actionTranslate(): Response {
    $translated = null;
    $translator = Plugin::getInstance()
      ->translators
      ->getTranslator();

    $request = $this->request;
    $source = $request->post('source');
    $target = $request->post('target');
    $text = HtmlPurifier::process($request->post('text'));

    if (!empty($source) && !empty($target) && !empty($text) && !is_null($translator)) {
      $translated = $translator->translate($source, $target, $text);
    }

    if (!is_null($translated)) {
      return $this->asJson([
        'success' => true,
        'data'    => $translated,
      ]);
    }

    return $this->asJson([
      'success' => false,
    ]);
  }
}
