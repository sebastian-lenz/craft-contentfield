<?php

namespace lenz\contentfield\events;

use Craft;
use craft\base\ElementInterface;
use craft\base\Volume;
use craft\errors\InvalidSubpathException;
use craft\errors\InvalidVolumeException;
use craft\errors\VolumeException;
use craft\helpers\FileHelper;
use craft\models\VolumeFolder;
use Exception;
use lenz\craft\utils\helpers\ArrayHelper;
use Throwable;
use yii\base\InvalidConfigException;

/**
 * Class ReferenceFolderSourcesEvent
 */
class ReferenceFolderSourcesEvent extends ReferenceSourcesEvent
{
  /**
   * @var boolean
   */
  public $showUnpermittedVolumes = false;

  /**
   * @var VolumeFolder[]|null
   */
  private $_folders;


  /**
   * @inheritDoc
   */
  public function __construct($config = []) {
    parent::__construct([
      'sources' => self::resolveSources(
        ArrayHelper::get($config, 'sources'),
        ArrayHelper::get($config, 'element')
      ),
    ] + $config);
  }

  /**
   * @param VolumeFolder $folder
   */
  public function addFolder(VolumeFolder $folder) {
    if (!is_array($this->_folders)) {
      $this->_folders = [];
    }

    if (!$this->contains($folder)) {
      $this->_folders[] = $folder;
    }
  }

  /**
   * @inheritDoc
   */
  public function addSource(string $source) {
    $folder = self::toFolder($source);
    if (!is_null($folder)) {
      $this->addFolder($folder);
    }
  }

  /**
   * @param mixed $value
   * @return bool
   */
  public function contains($value): bool {
    $value = self::toFolder($value);
    if (is_null($value) || !is_array($this->_folders)) {
      return false;
    }

    foreach ($this->_folders as $folder) {
      if ($folder->uid == $value->uid) {
        return true;
      }
    }

    return false;
  }

  /**
   * @return VolumeFolder[]|null
   */
  public function getFolders(): ?array {
    return $this->_folders;
  }

  /**
   * @inheritDoc
   */
  public function getSources(): ?array {
    $folders = $this->_folders;
    if (is_null($folders)) {
      return null;
    }

    if (!$this->showUnpermittedVolumes) {
      $folders = self::filterPermittedFolders($folders);
    }

    return array_map([self::class, 'toElementSource'], $folders);
  }

  /**
   * @param array|null $value
   */
  public function setFolders(array $value = null) {
    $this->setSources($value);
  }

  /**
   * @inheritDoc
   */
  public function setSources(array $value = null) {
    if (is_null($value)) {
      $this->_folders = null;
    } else {
      $this->_folders = array_filter(
        array_map([self::class, 'toFolder'], $value)
      );
    }
  }


  // Static methods
  // --------------

  /**
   * @param VolumeFolder[] $folders
   * @return VolumeFolder[]
   */
  static public function filterPermittedFolders(array $folders): array {
    if (empty($folders)) {
      return $folders;
    }

    $users = Craft::$app->getUser();

    return array_filter($folders, function(VolumeFolder $folder) use ($users) {
      try {
        $volume = $folder->getVolume();
      } catch (InvalidConfigException $e) {
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
  static public function resolvePath(string $path, ElementInterface $element = null): string {
    try {
      $result = Craft::$app->getView()->renderObjectTemplate($path, $element);
    } catch (Throwable $e) {
      throw new InvalidSubpathException($path, null, 0, $e);
    }

    // Did any of the tokens return null?
    if (
      $result === '' ||
      trim($result, '/') != $result ||
      strpos($result, '//') !== false
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
  static public function resolveSources(array $sources = null, ElementInterface $element = null): ?array {
    if (is_null($sources)) {
      return null;
    }

    $sources = array_map(function($source) use ($element) {
      if (is_string($source) && strpos($source, '/') !== false) {
        try {
          $parts = explode('/', $source, 2);
          return self::resolveVolumePath($parts[0], $parts[1], $element);
        } catch (Exception $e) {
          return null;
        }
      }

      return self::toFolder($source);
    }, $sources);

    return array_filter($sources);
  }

  /**
   * @param Volume|string $volumeSource
   * @param string $path
   * @param ElementInterface|null $element
   * @param bool $createFolders
   * @return VolumeFolder
   * @throws InvalidSubpathException|InvalidVolumeException|VolumeException
   */
  static public function resolveVolumePath(
        $volumeSource, string $path, ElementInterface $element = null,
        bool $createFolders = true): VolumeFolder {
    $assets = Craft::$app->getAssets();
    $volume = self::toVolume($volumeSource);
    if (is_null($volume)) {
      throw new InvalidVolumeException();
    }

    $path = is_string($path) ? trim($path, '/') : '';
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

    return $assets->getFolderById(
      $assets->ensureFolderByFullPathAndVolume($path, $volume)
    );
  }

  /**
   * @param string $value
   * @return string
   */
  static public function sanitizePath(string $value): string {
    $asciiOnly =  Craft::$app
      ->getConfig()
      ->getGeneral()
      ->convertFilenamesToAscii;

    $segments = array_map(function(string $segment) use ($asciiOnly) {
      return FileHelper::sanitizeFilename($segment, [
        'asciiOnly' => $asciiOnly
      ]);
    }, explode('/', $value));

    return implode('/', $segments);
  }

  /**
   * @param Volume|VolumeFolder|string|null $value
   * @return VolumeFolder|null
   */
  static public function toFolder($value) {
    $value = self::toVolumeOrFolder($value);

    if ($value instanceof Volume) {
      return Craft::$app->getAssets()->getRootFolderByVolumeId($value->id);
    } else {
      return $value;
    }
  }

  /**
   * @param VolumeFolder $folder
   * @return string
   */
  static public function toSource(VolumeFolder $folder): string {
    return 'folder:' . $folder->uid;
  }

  /**
   * @param VolumeFolder $folder
   * @return string
   */
  private function toElementSource(VolumeFolder $folder): string {
    $segments = [self::toSource($folder)];

    while ($folder->parentId && $folder->volumeId !== null) {
      $folder = $folder->getParent();
      $segments[] = self::toSource($folder);
    }

    return implode('/', array_reverse($segments));
  }

  /**
   * @param Volume|VolumeFolder|string|null $value
   * @return Volume|null
   */
  static public function toVolume($value): ?Volume {
    $value = self::toVolumeOrFolder($value);

    if ($value instanceof VolumeFolder) {
      try {
        $volume = $value->getVolume();
        $rootFolder = Craft::$app
          ->getAssets()
          ->getRootFolderByVolumeId($volume->id);

        $value = $rootFolder->id === $value->id
          ? $volume
          : null;
      } catch (InvalidConfigException $e) {
        return null;
      }
    }

    return $value instanceof Volume ? $value : null;
  }

  /**
   * @param Volume|VolumeFolder|string|null $value
   * @return Volume|VolumeFolder|null
   */
  static public function toVolumeOrFolder($value) {
    if (is_string($value)) {
      $parts = explode(':', $value, 2);
      if (count($parts) !== 2) {
        return null;
      }

      if ($parts[0] == 'volume') {
        $value = Craft::$app->getVolumes()->getVolumeByUid($parts[1]);
      } elseif ($parts[0] == 'folder') {
        $value = Craft::$app->getAssets()->getFolderByUid($parts[1]);
      }
    }

    if ($value instanceof Volume || $value instanceof VolumeFolder) {
      return $value;
    } else {
      return null;
    }
  }
}
