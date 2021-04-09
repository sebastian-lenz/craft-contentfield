<?php

namespace lenz\contentfield\controllers;

use Craft;
use craft\errors\InvalidFieldException;
use craft\web\Controller;
use Exception;
use lenz\contentfield\fields\content\InputData;
use lenz\contentfield\models\Content;
use lenz\contentfield\models\fields\OEmbedField;
use lenz\contentfield\Plugin;
use lenz\craft\utils\events\AnchorsEvent;
use yii\web\Response;

/**
 * Class CpController
 */
class CpController extends Controller
{
  /**
   * @param string $siteId
   * @param string $elementId
   * @return Response
   */
  public function actionAnchors(string $siteId, string $elementId): Response {
    try {
      $anchors = AnchorsEvent::findAnchorsById($elementId, $siteId);
    } catch (Exception $e) {
      return $this->asJson([ 'result' => false ]);
    }

    return $this->asJson([
      'anchors' => $anchors,
      'result' => true,
    ]);
  }

  /**
   * @param string|int $siteId
   * @param string|int $elementId
   * @param string $fieldHandle
   * @return Response
   * @throws InvalidFieldException
   */
  public function actionFetch($siteId, $elementId, string $fieldHandle): Response {
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
   * @param string $schema
   * @param string $field
   * @param string $url
   * @return Response
   * @throws Exception
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
   * @param string $source
   * @param string $target
   * @param string $text
   * @return Response
   */
  public function actionTranslate(string $source, string $target, string $text): Response {
    $translated = null;
    $translator = Plugin::getInstance()
      ->translators
      ->getTranslator();

    if (!is_null($translator)) {
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
