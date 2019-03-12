<?php

namespace sebastianlenz\contentfield\controllers;

use sebastianlenz\contentfield\fields\ContentField;
use sebastianlenz\contentfield\models\Content;
use sebastianlenz\contentfield\models\fields\OEmbedField;
use sebastianlenz\contentfield\Plugin;
use sebastianlenz\contentfield\utilities\Url;
use craft\web\Controller;

/**
 * Class CpController
 */
class CpController extends Controller
{
  /**
   * @var string
   */
  const GOOGLE_TRANSLATE_ENDPOINT = 'https://www.googleapis.com/language/translate/v2';


  /**
   * @param integer $siteId
   * @param integer $elementId
   * @param string $fieldHandle
   * @return \yii\web\Response
   */
  public function actionFetch($siteId, $elementId, $fieldHandle) {
    $element = \Craft::$app->elements->getElementById($elementId, null, $siteId);
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

    if (is_null($value->model)) {
      return $this->asJson([
        'result'  => false,
        'message' => 'The site contains no data.'
      ]);
    }

    return $this->asJson([
      'result'     => true,
      'data'       => $value->model->getEditorData(),
      'references' => ContentField::loadReferences($value),
    ]);
  }

  /**
   * @param string $schema
   * @param string $field
   * @param string $url
   * @return \yii\web\Response
   * @throws \Exception
   */
  public function actionOembed($schema, $field, $url) {
    $instance = Plugin::getInstance()->schemas->getSchema($schema);
    if (is_null($schema)) {
      throw new \Exception('Invalid schema provided: ' . $schema);
    }

    if (
      !array_key_exists($field, $instance->fields) ||
      !($instance->fields[$field] instanceof OEmbedField)
    ) {
      throw new \Exception('Invalid field provided: ' . $field);
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
   * @return \yii\web\Response
   */
  public function actionTranslate($source, $target, $text) {
    $apiKey = Plugin::getInstance()
      ->getSettings()
      ->googleTranslateApiKey;

    if (empty($apiKey) || empty(trim($text))) {
      return $this->asJson([
        'success' => true,
        'data'    => $text,
      ]);
    }

    $url = new Url(self::GOOGLE_TRANSLATE_ENDPOINT);
    $url->setQuery([
      'key'    => $apiKey,
      'q'      => $text,
      'source' => $source,
      'target' => $target,
    ]);

    $handle = curl_init((string)$url);
    curl_setopt($handle, CURLOPT_RETURNTRANSFER, true);
    $response = curl_exec($handle);
    $responseDecoded = json_decode($response, true);
    $responseCode = curl_getinfo($handle, CURLINFO_HTTP_CODE);
    curl_close($handle);

    if ($responseCode != 200) {
      $this->asJson([
        'success' => false,
      ]);
    }

    return $this->asJson([
      'success' => true,
      'data' => $responseDecoded['data']['translations'][0]['translatedText'],
    ]);
  }
}
