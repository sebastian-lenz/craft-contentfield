<?php

namespace lenz\contentfield\events;

use Craft;
use craft\base\ElementInterface;
use craft\errors\InvalidSubpathException;
use craft\errors\VolumeException;
use craft\helpers\FileHelper;
use craft\models\Volume;
use craft\models\VolumeFolder;
use Exception;
use lenz\craft\utils\helpers\ArrayHelper;
use Throwable;
use yii\base\InvalidConfigException;
use yii\base\InvalidValueException;

/**
 * Class ReferenceFolderSourcesEvent
 * @extends AbstractSourcesEvent<Volume|VolumeFolder, Volume|VolumeFolder|string|null>
 */
class ReferenceFolderSourcesEvent extends AbstractSourcesEvent
{
  /**
   * @var boolean
   */
  public bool $showUnpermittedVolumes = false;


  /**
   * @inheritDoc
   */
  public function __construct($config = []) {
    $config['sources'] = self::resolveSources(
      ArrayHelper::get($config, 'sources'),
      ArrayHelper::get($config, 'element')
    );

    parent::__construct($config);
  }

  /**
   * @return VolumeFolder[]
   * @noinspection PhpUnused
   */
  public function getFolders(): array {
    return $this->_values;
  }

  /**
   * @inheritDoc
   */
  public function getSources(): ?array {
    $folders = $this->_values;
    if (!$this->showUnpermittedVolumes) {
      $folders = self::filterPermittedFolders($folders);
    }

    return empty($folders)
      ? null
      : array_map([self::class, 'toElementSource'], $folders);
  }


  // Protected methods
  // -----------------

  /**
   * @inheritDoc
   */
  protected function isEqual(mixed $lft, mixed $rgt): bool {
    return $lft->uid == $rgt->uid;
  }

  /**
   * @inheritDoc
   */
  protected function toValue(mixed $value): Volume|VolumeFolder|null {
    return self::toVolumeOrFolder($value);
  }


  // Static methods
  // --------------

  /**
   * @param VolumeFolder[] $folders
   * @return VolumeFolder[]
   */
  static private function filterPermittedFolders(array $folders): array {
    if (empty($folders)) {
      return $folders;
    }

    $users = Craft::$app->getUser();

    return array_filter($folders, function(Volume|VolumeFolder $value) use ($users) {
      try {
        $volume = $value instanceof Volume ? $value : $value->getVolume();
      } catch (InvalidConfigException) {
        $volume = null;
      }

      return (
        !($volume instanceof Volume) ||
        $users->checkPermission('viewVolume:' . $volume->uid)
      );
    });
  }

  /**
   * @param string $path
   * @param ElementInterface|null $element
   * @return string
   * @throws InvalidSubpathException
   */
  static private function resolvePath(string $path, ElementInterface $element = null): string {
    try {
      $result = Craft::$app->getView()->renderObjectTemplate($path, $element);
    } catch (Throwable $e) {
      throw new InvalidSubpathException($path, null, 0, $e);
    }

    // Did any of the tokens return null?
    if (
      $result === '' ||
      trim($result, '/') != $result ||
      str_contains($result, '//')
    ) {
      throw new InvalidSubpathException($path);
    }

    return self::sanitizePath($result);
  }

  /**
   * @param array|null $sources
   * @param ElementInterface|null $element
   * @return VolumeFolder[]|null
   */
  static private function resolveSources(array $sources = null, ElementInterface $element = null): ?array {
    if (empty($sources)) {
      return null;
    }

    $sources = array_map(function($source) use ($element) {
      if (is_string($source) && str_contains($source, '/')) {
        try {
          $parts = explode('/', $source, 2);
          return self::resolveVolumePath($parts[0], $parts[1], $element);
        } catch (Exception) {
          return null;
        }
      }

      return self::toVolumeOrFolder($source);
    }, $sources);

    return array_filter($sources);
  }

  /**
   * @param string|Volume $volumeSource
   * @param string $path
   * @param ElementInterface|null $element
   * @param bool $createFolders
   * @return VolumeFolder
   * @throws InvalidSubpathException
   * @throws VolumeException
   */
  static private function resolveVolumePath(
    Volume|string $volumeSource,
    string $path,
    ElementInterface $element = null,
    bool $createFolders = true
  ): VolumeFolder {
    $assets = Craft::$app->getAssets();
    $volume = self::toVolume($volumeSource);
    if (is_null($volume)) {
      throw new InvalidValueException();
    }

    $path = trim($path, '/');
    if (empty($path)) {
      return $assets->getRootFolderByVolumeId($volume->id);
    }

    $path = self::resolvePath($path, $element);
    $folder = $assets->findFolder([
      'volumeId' => $volume->id,
      'path' => $path . '/'
    ]);

    if (!is_null($folder)) {
      return $folder;
    } elseif (!$createFolders) {
      throw new InvalidSubpathException($path);
    }

    return $assets->ensureFolderByFullPathAndVolume($path, $volume);
  }

  /**
   * @param string $value
   * @return string
   */
  static private function sanitizePath(string $value): string {
    $asciiOnly =  Craft::$app
      ->getConfig()
      ->getGeneral()
      ->convertFilenamesToAscii;

    $segments = array_map(
      fn(string $segment) => FileHelper::sanitizeFilename($segment, ['asciiOnly' => $asciiOnly]),
      explode('/', $value)
    );

    return implode('/', $segments);
  }

  /**
   * @param Volume|VolumeFolder $value
   * @return string
   */
  static private function toSource(Volume|VolumeFolder $value): string {
    if ($value instanceof Volume) {
      return 'volume:' . $value->uid;
    }

    return empty($value->parentId)
      ? 'volume:' . $value->volume->uid
      : 'folder:' . $value->uid;
  }

  /**
   * @param Volume|VolumeFolder $value
   * @return string
   */
  static private function toElementSource(Volume|VolumeFolder $value): string {
    $segments = [self::toSource($value)];
    while ($value instanceof VolumeFolder && !empty($value->parentId)) {
      $value = $value->getParent();
      $segments[] = self::toSource($value);
    }

    return implode('/', array_reverse($segments));
  }

  /**
   * @param string|Volume|VolumeFolder|null $value
   * @return Volume|null
   */
  static private function toVolume(VolumeFolder|Volume|string|null $value): ?Volume {
    $value = self::toVolumeOrFolder($value);
    if ($value instanceof Volume || is_null($value)) {
      return $value;
    }

    try {
      $volume = $value->getVolume();
      $rootFolder = Craft::$app
        ->getAssets()
        ->getRootFolderByVolumeId($volume->id);

      return $rootFolder->id === $value->id ? $volume : null;
    } catch (InvalidConfigException) {
      return null;
    }
  }

  /**
   * @param string|Volume|VolumeFolder|null $value
   * @return Volume|VolumeFolder|null
   */
  static private function toVolumeOrFolder(VolumeFolder|Volume|string|null $value): Volume|VolumeFolder|null {
    if ($value instanceof Volume || $value instanceof VolumeFolder || is_null($value)) {
      return $value;
    }

    $parts = explode(':', $value, 2);
    if (count($parts) !== 2) {
      return null;
    }

    if ($parts[0] == 'volume') {
      return Craft::$app->getVolumes()->getVolumeByUid($parts[1]);
    } elseif ($parts[0] == 'folder') {
      return Craft::$app->getAssets()->getFolderByUid($parts[1]);
    } else {
      return null;
    }
  }
}
