<?php

namespace lenz\contentfield\services\definitions;

use craft\elements\Asset;
use craft\helpers\Json;
use Exception;
use lenz\contentfield\Plugin;
use lenz\contentfield\services\imageTags\ConfigImageTag;
use lenz\contentfield\services\imageTags\ImageImageTag;
use lenz\contentfield\services\imageTags\ImageTagInterface;
use lenz\contentfield\services\imageTags\ImageTransformExtractorInterface;
use lenz\contentfield\services\imageTags\PictureImageTag;
use lenz\contentfield\services\imageTags\TemplateImageTag;
use yii\caching\TagDependency;

/**
 * Class ImageTagDefinitions
 */
class ImageTagDefinitions extends AbstractDefinitions
{
  /**
   * @var array<string, class-string<ImageTagInterface>>
   */
  private array $_imageTags;


  /**
   * ImageTags constructor.
   */
  public function __construct() {
    $this->_imageTags = [
      'config'   => ConfigImageTag::class,
      'image'    => ImageImageTag::class,
      'picture'  => PictureImageTag::class,
      'template' => TemplateImageTag::class,
    ];
  }

  /**
   * @return array
   */
  public function getAllTransforms(): array {
    if (!isset($this->definitions)) {
      $this->loadDefinitions();
    }

    $allTransforms = [];
    foreach ($this->_imageTags as $imageTag) {
      if (!is_a($imageTag, ImageTransformExtractorInterface::class)) {
        continue;
      }

      foreach ($this->definitions as $definition) {
        $allTransforms = array_merge(
          $allTransforms,
          $imageTag::extractTransforms($definition)
        );
      }
    }

    $result = [];
    foreach ($allTransforms as $transform) {
      foreach ($result as $existingTransform) {
        if ($existingTransform == $transform) {
          continue 2;
        }
      }

      $result[] = $transform;
    }

    return $result;
  }

  /**
   * @param Asset $asset
   * @param array|string $config
   * @return string|null
   * @throws Exception
   */
  public function render(Asset $asset, array|string $config): ?string {
    if (!is_array($config)) {
      $config = [
        'type' => $config
      ];
    }

    if (!array_key_exists('type', $config)) {
      $config['type'] = 'image';
    }

    $config = $this->resolveDefinition($config);
    $cache = Plugin::getInstance()->imageTagCache;
    $cacheKey = __METHOD__ . '(' . md5(Json::encode([
      'asset'  => $asset->uid,
      'config' => $config,
      'mtime'  => $asset->dateModified,
      'site'   => $asset->siteId,
    ])) . ')';

    $result = $cache->get($cacheKey);
    if ($result !== false) {
      return $result;
    }

    $result = $this->renderInternal($asset, $config);
    if (!str_contains($result, 'actions/assets/generate-transform')) {
      $cache->set($cacheKey, $result, null, new TagDependency(['tags' => $asset->uid]));
    }

    return $result;
  }

  /**
   * @param string $type
   * @param class-string<ImageTagInterface> $imageTagClass
   * @noinspection PhpUnused
   */
  public function registerImageTag(string $type, string $imageTagClass) {
    $this->_imageTags[$type] = $imageTagClass;
  }


  // Protected methods
  // -----------------

  /**
   * @return string
   */
  protected function getDefinitionName(): string {
    return 'imagetags';
  }

  /**
   * @param array $config
   * @return class-string<ImageTagInterface>
   * @throws Exception
   */
  protected function getImageTagClass(array $config): string {
    $type = $config['type'];
    if (!array_key_exists($type, $this->_imageTags)) {
      throw new Exception('Invalid image tag type: ' .  $type);
    }

    return $this->_imageTags[$type];
  }

  /**
   * @param string $type
   * @return boolean
   */
  protected function isNativeType(string $type): bool {
    return array_key_exists($type, $this->_imageTags);
  }

  /**
   * @param array $config
   * @param array $parent
   * @return array
   * @throws Exception
   */
  protected function mergeDefinitions(array $config, array $parent): array {
    $imageTagClass = $this->getImageTagClass($parent);
    return $imageTagClass::mergeConfig($config, $parent);
  }

  /**
   * @param Asset $asset
   * @param array $config
   * @return string|null
   * @throws Exception
   */
  protected function renderInternal(Asset $asset, array $config): ?string {
    $imageTagClass = $this->getImageTagClass($config);
    $type = $config['type'];
    unset($config['type']);

    $imageTag = new $imageTagClass($asset, $config);

    if (!($imageTag instanceof ImageTagInterface)) {
      throw new Exception(sprintf(
        'Invalid image tag class `%s` for type %s.', $imageTagClass, $type)
      );
    }

    return $imageTag->isSupported()
      ? $imageTag->render()
      : null;
  }
}
