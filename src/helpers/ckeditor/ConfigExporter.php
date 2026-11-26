<?php

namespace lenz\contentfield\helpers\ckeditor;

use Craft;
use craft\helpers\FileHelper;
use craft\helpers\ProjectConfig as ProjectConfigHelper;
use craft\helpers\StringHelper;
use Symfony\Component\Yaml\Yaml;
use Throwable;
use yii\base\Exception;

/**
 * Class ConfigExporter
 *
 * Exports legacy CKEditor configs (craftcms/ckeditor < 5, stored in the
 * project config at `ckeditor.configs`) to `config/content/cke`, where the
 * `ckeditor` content field type expects them.
 */
class ConfigExporter
{
  /**
   * Settings of a legacy config that are copied to the exported file.
   */
  const EXPORTED_SETTINGS = [
    'toolbar',
    'headingLevels',
    'advancedLinkFields',
    'options',
    'js',
    'css',
  ];

  /**
   * Regular expression matching a uid.
   */
  const UID_PATTERN = '[0-9a-f]{8}-[0-9a-f]{4}-[0-9a-f]{4}-[0-9a-f]{4}-[0-9a-f]{12}';


  /**
   * Exports the given legacy configs. Configs that already have been
   * exported (a file with the same uid exists) are skipped.
   *
   * @param array $configs The legacy configs, indexed by their uid.
   * @return array<string, string> The names of the exported configs, indexed by their uid.
   * @throws Exception
   */
  static public function export(array $configs): array {
    $path = self::getConfigPath();
    $existing = self::getExportedUids();
    $result = [];

    foreach ($configs as $uid => $config) {
      if (!is_string($uid) || !is_array($config) || isset($existing[$uid])) {
        continue;
      }

      $config = ProjectConfigHelper::unpackAssociativeArrays($config);
      $label = is_string($config['name'] ?? null) && $config['name'] !== ''
        ? $config['name']
        : $uid;

      $name = self::getUniqueName($path, StringHelper::toKebabCase($label) ?: $uid);
      FileHelper::writeToFile(
        $path . DIRECTORY_SEPARATOR . $name . '.yml',
        self::toYaml($uid, $label, $config)
      );

      $existing[$uid] = $name;
      $result[$uid] = $name;
    }

    return $result;
  }

  /**
   * Extracts legacy configs from a project config change event.
   *
   * @param string $path
   * @param mixed $value
   * @return array The legacy configs, indexed by their uid.
   */
  static public function extractConfigs(string $path, mixed $value): array {
    if (!is_array($value)) {
      return [];
    }

    if ($path === 'ckeditor') {
      $value = $value['configs'] ?? [];
      return is_array($value) ? $value : [];
    }

    if ($path === 'ckeditor.configs') {
      return $value;
    }

    if (preg_match('/^ckeditor\.configs\.(' . self::UID_PATTERN . ')$/', $path, $match)) {
      return [$match[1] => $value];
    }

    return [];
  }

  /**
   * Returns the directory exported configs are stored in.
   *
   * @return string
   */
  static public function getConfigPath(): string {
    return implode(DIRECTORY_SEPARATOR, [
      Craft::$app->getConfig()->configDir,
      'content',
      'cke',
    ]);
  }

  /**
   * Returns the uids of all configs stored in `config/content/cke`.
   *
   * @return array<string, string> The config names, indexed by their uid.
   */
  static public function getExportedUids(): array {
    $path = self::getConfigPath();
    if (!is_dir($path)) {
      return [];
    }

    $result = [];
    $files = FileHelper::findFiles($path, ['only' => ['*.yml', '*.yaml']]);
    foreach ($files as $file) {
      try {
        $data = Yaml::parseFile($file);
      } catch (Throwable) {
        continue;
      }

      if (is_array($data) && is_string($data['uid'] ?? null)) {
        $name = substr($file, strlen($path) + 1);
        $name = preg_replace('/\.ya?ml$/', '', str_replace(DIRECTORY_SEPARATOR, '/', $name));
        $result[$data['uid']] = $name;
      }
    }

    return $result;
  }


  // Private methods
  // ---------------

  /**
   * @param string $path
   * @param string $name
   * @return string
   */
  static private function getUniqueName(string $path, string $name): string {
    $result = $name;
    $index = 2;
    while (
      file_exists("$path/$result.yml") ||
      file_exists("$path/$result.yaml")
    ) {
      $result = $name . '-' . $index++;
    }

    return $result;
  }

  /**
   * @param string $uid
   * @param string $label
   * @param array $config
   * @return string
   */
  static private function toYaml(string $uid, string $label, array $config): string {
    $data = ['uid' => $uid];
    foreach (self::EXPORTED_SETTINGS as $key) {
      if (array_key_exists($key, $config) && $config[$key] !== null) {
        $data[$key] = $config[$key];
      }
    }

    // `anchor` has been renamed to `bookmark` in craftcms/ckeditor 5
    if (isset($data['toolbar']) && is_array($data['toolbar'])) {
      $data['toolbar'] = array_values(array_map(
        fn($item) => $item === 'anchor' ? 'bookmark' : $item,
        $data['toolbar']
      ));
    }

    return implode("\n", [
      "# $label",
      '# Exported from the CKEditor config of the project config. The uid allows',
      '# legacy `ckeConfig: <uid>` references to resolve, reference this config by',
      '# its file name instead, see `php craft contentfield/cke/check --fix`.',
      Yaml::dump($data, 10, 2),
    ]);
  }
}
