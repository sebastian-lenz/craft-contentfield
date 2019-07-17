<?php

namespace lenz\contentfield\models\fields;

use lenz\contentfield\models\enumerations\VolumeFolderEnumeration;

/**
 * Class SelectField
 *
 * Displays a textarea input.
 */
class SelectField extends AbstractEnumerationField
{
  /**
   * The internal name of this widget.
   */
  const NAME = 'select';


  // Static methods
  // --------------

  /**
   * @inheritDoc
   */
  public static function expandFieldConfig(&$config) {
    if ($config['type'] === 'volumeFolder') {
      $params = [];
      if (isset($config['rootFolders'])) {
        $params[] = $config['rootFolders'];
        unset($config['rootFolders']);
      }

      $config['type'] = 'select';
      $config['enumeration'] = $params + [
        'type' => VolumeFolderEnumeration::class,
      ];
    }
  }
}
