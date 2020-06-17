<?php

namespace lenz\contentfield\tests\unit\fieldTypes;

use lenz\contentfield\models\fields\OEmbedField;
use lenz\contentfield\models\values\OEmbedValue;
use lenz\contentfield\services\oembeds\Endpoint;
use lenz\contentfield\services\oembeds\OEmbed;
use lenz\contentfield\services\oembeds\Provider;
use Throwable;

/**
 * Class OEmbedFieldTest
 *
 * @method OEmbedField createField(array $options)
 * @method OEmbedField loadField(string $name, string $schema = null)
 */
class OEmbedFieldTest extends AbstractFieldTest
{
  /**
   * @inheritDoc
   */
  const FIELD_CLASS = OEmbedField::class;

  /**
   * @inheritDoc
   */
  const FIELD_DEFAULT_SCHEMA = 'unit/fieldTypes/oembed';

  /**
   * @inheritDoc
   */
  const FIELD_OPTIONS = [
    'providers' => 'youtube',
    'type'      => OEmbedField::NAME
  ];

  /**
   * @var array
   */
  const TEST_URLS = [
    'soundcloud' => 'https://soundcloud.com/pmcomposer/frostpunk-theme',
    'youtube'    => 'https://www.youtube.com/watch?v=jNQXAC9IVRw',
    'vimeo'      => 'https://vimeo.com/413529682',
  ];


  /**
   * @throws Throwable
   */
  public function testEditorValue() {
    $oEmbed = $this->createOEmbed();
    $field = $this->createField([
      'name' => 'testEditorValue',
    ]);

    $this->assertNull($field->getEditorValue(self::TEXT_DATA));

    $editorValue = $field->getEditorValue($oEmbed);
    $this->tester->assertArrayMembers([
      'url'  => 'string',
      'info' => 'object',
    ], $editorValue);
  }

  /**
   * @throws Throwable
   */
  public function testEndpoints() {
    $field = $this->loadField('endpoints');

    foreach (self::TEST_URLS as $provider => $url) {
      $endpoint = $field->getEndpoint($url);
      $this->assertInstanceOf(Endpoint::class, $endpoint);

      $oEmbed = $field->getOEmbed($url);
      $this->assertInstanceOf(OEmbed::class, $oEmbed);
      $this->assertEquals($endpoint, $oEmbed->getEndpoint());
    }
  }

  /**
   * @throws Throwable
   */
  public function testSerializedValue() {
    $field = $this->createField([
      'name' => 'testSerializedValue',
    ]);

    $this->assertNull($field->getSerializedValue(1024));
    $this->assertNull($field->getSerializedValue(true));
    $this->assertNull($field->getSerializedValue(self::TEXT_DATA));
    $this->assertIsString($field->getSerializedValue($this->createOEmbed()));
  }

  /**
   * @throws Throwable
   */
  public function testYoutubeAlias() {
    $field = $this->loadField('youtubeAlias');

    $this->assertCount(1, array_filter($field->providers, function(Provider $provider) {
      return $provider->searchName == 'youtube';
    }));
  }

  /**
   * @throws Throwable
   */
  public function testValue() {
    $field = $this->createField([
      'name' => 'testValue',
    ]);

    $this->assertInstanceOf(OEmbedValue::class, $field->createValue(true));
    $this->assertInstanceOf(OEmbedValue::class, $field->createValue(156));
    $this->assertInstanceOf(OEmbedValue::class, $field->createValue(self::TEXT_DATA));
  }


  // Protected methods
  // -----------------

  /**
   * @return OEmbedValue
   */
  protected function createOEmbed() {
    return new OEmbedValue(self::TEST_URLS['youtube']);
  }
}
