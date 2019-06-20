<?php

namespace lenz\contentfield\models\enumerations;

use craft\helpers\StringHelper;
use craft\models\VolumeFolder;

/**
 * Class VolumeFolderEnumeration
 */
class VolumeFolderEnumeration implements EnumerationInterface
{
  /**
   * @var VolumeFolder[]
   */
  protected $_folders = [];

  /**
   * @var int
   */
  protected $_maxDepth = -1;

  /**
   * @var array
   */
  protected $_options;

  /**
   * @var VolumeFolder[]
   */
  protected $_rootFolders;

  /**
   * @var string[]
   */
  protected $_rootUids;


  /**
   * VolumeFolderEnumeration constructor.
   * @param array $options
   */
  public function __construct($options = array()) {
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
   * @param string|int $key
   * @param string $name
   * @return mixed
   */
  public function getCustomData($key, $name) {
    if (!array_key_exists($key, $this->_folders)) {
      $this->_folders[$key] = \Craft::$app->getAssets()
        ->findFolder(['uid' => $key]);
    }

    $folder = $this->_folders[$key];
    if (!($folder instanceof VolumeFolder)) {
      return null;
    }

    return $name == 'folder' ? $folder : $folder->$name;
  }

  /**
   * @inheritdoc
   */
  public function getOptions() {
    if (!isset($this->_options)) {
      $this->_options = array();
      foreach ($this->getRootFolders() as $folder) {
        $this->toOptions($this->_options, $folder);
      }
    }

    return $this->_options;
  }


  // Private methods
  // ---------------

  /**
   * @return VolumeFolder[]
   */
  private function getRootFolders() {
    if (!isset($this->_rootFolders)) {
      $assets = \Craft::$app->getAssets();

      if ($this->_rootUids) {
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
  private function toOptions(&$options, $folder, $depth = 0) {
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