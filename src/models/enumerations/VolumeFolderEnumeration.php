<?php

namespace lenz\contentfield\models\enumerations;

use Craft;
use craft\helpers\StringHelper;
use craft\models\VolumeFolder;

/**
 * Class VolumeFolderEnumeration
 *
 * This enumeration is experimental.
 */
class VolumeFolderEnumeration implements CustomDataInterface, EnumerationInterface
{
  /**
   * @var array
   */
  protected array $_folders = [];

  /**
   * @var int
   */
  protected int $_maxDepth = -1;

  /**
   * @var array
   */
  protected array $_options;

  /**
   * @var VolumeFolder[]
   */
  protected array $_rootFolders;

  /**
   * @var string[]
   */
  protected array $_rootUids;


  /**
   * VolumeFolderEnumeration constructor.
   * @param array $options
   */
  public function __construct(array $options = []) {
    if (isset($options['rootFolders'])) {
      $args = is_array($options['rootFolders'])
        ? $options['rootFolders']
        : [ $options['rootFolders'] ];

      $uids = [];
      foreach ($args as $arg) {
        if (preg_match('/(' . StringHelper::UUID_PATTERN . ')/', $arg, $match)) {
          $uids[] = $match[1];
        }
      }

      $this->_rootUids = $uids;
    }
  }

  /**
   * @param int|string $key
   * @param string $name
   * @return mixed
   */
  public function getCustomData(int|string $key, string $name): mixed {
    $folder = $this->getFolder($key);
    return $folder instanceof VolumeFolder && isset($folder->$name)
      ? $folder->$name
      : null;
  }

  /**
   * @inheritdoc
   */
  public function getOptions(): array {
    if (!isset($this->_options)) {
      $this->_options = [];
      foreach ($this->getRootFolders() as $folder) {
        $this->toOptions($this->_options, $folder);
      }
    }

    return $this->_options;
  }

  /**
   * @inheritDoc
   */
  public function hasCustomData(int|string $key, string $name): bool {
    $folder = $this->getFolder($key);
    return $folder instanceof VolumeFolder && isset($folder->$name);
  }


  // Private methods
  // ---------------

  /**
   * @param string $key
   * @return VolumeFolder|null
   */
  private function getFolder(string $key): ?VolumeFolder {
    if (!array_key_exists($key, $this->_folders)) {
      $this->_folders[$key] = Craft::$app
        ->getAssets()
        ->findFolder(['uid' => $key]);
    }

    return $this->_folders[$key];
  }

  /**
   * @return VolumeFolder[]
   */
  private function getRootFolders(): array {
    if (!isset($this->_rootFolders)) {
      $assets = Craft::$app->getAssets();

      if (!empty($this->_rootUids)) {
        $this->_rootFolders = $assets->findFolders(['uid' => $this->_rootUids]);
      } else {
        $this->_rootFolders = $assets->findFolders(['parentId' => ':empty:']);
      }
    }

    return $this->_rootFolders;
  }

  /**
   * @param array $options
   * @param VolumeFolder $folder
   * @param int $depth
   */
  private function toOptions(array &$options, VolumeFolder $folder, int $depth = 0) {
    $options[] = [
      'key'    => $folder->id,
      'label'  => $folder->name,
      'indent' => $depth,
    ];

    if ($this->_maxDepth < 1 || $this->_maxDepth > $depth) {
      foreach ($folder->getChildren() as $child) {
        $this->toOptions($options, $child, $depth + 1);
      }
    }
  }
}
