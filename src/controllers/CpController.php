<?php

namespace lenz\contentfield\controllers;

use Craft;
use craft\web\Controller;
use Exception;
use lenz\contentfield\fields\content\InputData;
use lenz\contentfield\models\Content;
use lenz\contentfield\models\fields\OEmbedField;
use lenz\contentfield\Plugin;
use yii\web\Response;

/**
 * Class CpController
 */
class CpController extends Controller
{
  /**
   * @param integer $siteId
   * @param integer $elementId
   * @param string $fieldHandle
   * @return Response
   */
  public function actionFetch($siteId, $elementId, $fieldHandle) {
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
  public function actionOembed($schema, $field, $url) {
    $instance = Plugin::getInstance()->schemas->getSchema($schema);
    if (is_null($schema)) {
      throw new Exception('Invalid schema provided: ' . $schema);
    }

    if (
      !array_key_exists($field, $instance->fields) ||
      !($instance->fields[$field] instanceof OEmbedField)
    ) {
      throw new Exception('Invalid field provided: ' . $field);
    }

    /** @var OEmbedField $oembedField */
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
  public function actionTranslate($source, $target, $text) {
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
