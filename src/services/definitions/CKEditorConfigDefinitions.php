<?php

namespace lenz\contentfield\services\definitions;

use Craft;
use Exception;
use lenz\contentfield\helpers\ckeditor\ConfigExporter;

/**
 * Class CKEditorConfigDefinitions
 *
 * Loads the CKEditor configurations used by `ckeditor` fields. Configurations
 * are stored as one file per configuration within `config/content/cke`, the
 * file name (without extension, relative to that directory) is the name of
 * the configuration, e.g. `config/content/cke/default.yml` defines `default`.
 *
 * Each file may contain any of the settings of a native CKEditor field, e.g.
 *
 * ```yaml
 * toolbar: [heading, '|', bold, italic, link]
 * headingLevels: [2, 3]
 * advancedLinkFields: []
 * options:
 *   bodyClass: myEditor
 * css: null
 * ```
 *
 * Alternatively, all configurations can be stored in a single file at
 * `config/content/cke.yml`, using the configuration names as top level keys.
 */
class CKEditorConfigDefinitions extends AbstractDefinitions
{
  /**
   * Returns the configuration with the given name.
   *
   * @param string $name
   * @return array
   * @throws Exception
   */
  public function getConfig(string $name): array {
    if ($this->hasDefinition($name)) {
      return self::withoutMeta($this->getDefinition($name));
    }

    if (!self::isUid($name)) {
      throw new Exception(sprintf(
        'Unknown CKEditor config `%s`, expected a file at `config/content/cke/%s.yml`.',
        $name, $name
      ));
    }

    // Legacy reference to a config of craftcms/ckeditor < 5
    $resolved = $this->findNameByUid($name);
    if (is_null($resolved)) {
      throw new Exception(sprintf(
        'The CKEditor config `%s` is a legacy config of craftcms/ckeditor < 5, which ' .
        'no longer exists. Move the config to `config/content/cke/<name>.yml` and ' .
        'reference it by name, or restore it with `php craft contentfield/cke/export`.',
        $name
      ));
    }

    Craft::$app->getDeprecator()->log(
      "contentfield.ckeConfig.$name",
      sprintf(
        'The CKEditor config `%s` is referenced by its uid, use `ckeConfig: %s` instead. ' .
        'Run `php craft contentfield/cke/check --fix` to update all references.',
        $name, $resolved
      )
    );

    return self::withoutMeta($this->getDefinition($resolved));
  }

  /**
   * Returns the name of the config with the given uid.
   *
   * @param string $uid
   * @return string|null
   */
  public function findNameByUid(string $uid): ?string {
    if (!isset($this->definitions)) {
      $this->loadDefinitions();
    }

    foreach ($this->definitions as $name => $definition) {
      if (is_array($definition) && ($definition['uid'] ?? null) === $uid) {
        return (string)$name;
      }
    }

    return null;
  }

  /**
   * Returns the names of all available configs.
   *
   * @return string[]
   */
  public function getNames(): array {
    if (!isset($this->definitions)) {
      $this->loadDefinitions();
    }

    return array_map('strval', array_keys($this->definitions));
  }

  /**
   * @param string $value
   * @return bool
   */
  static public function isUid(string $value): bool {
    return (bool)preg_match('/^' . ConfigExporter::UID_PATTERN . '$/i', $value);
  }

  /**
   * Removes the meta data from the given config.
   *
   * @param array $config
   * @return array
   */
  static public function withoutMeta(array $config): array {
    unset($config['uid']);
    return $config;
  }


  // Protected methods
  // -----------------

  /**
   * @inheritDoc
   */
  protected function getDefinitionName(): string {
    return 'cke';
  }

  /**
   * @inheritDoc
   */
  protected function isNativeType(string $type): bool {
    return true;
  }

  /**
   * @inheritDoc
   */
  protected function isTypeRequired(): bool {
    return false;
  }

  /**
   * @inheritDoc
   */
  protected function parseDefinitionSource(string $key, string $pathname): array {
    $definitions = parent::parseDefinitionSource($key, $pathname);
    return $key === '*' ? $definitions : [$key => $definitions];
  }
}
