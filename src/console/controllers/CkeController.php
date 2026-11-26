<?php

namespace lenz\contentfield\console\controllers;

use Craft;
use craft\console\Controller;
use craft\helpers\Console;
use craft\helpers\FileHelper;
use lenz\contentfield\helpers\ckeditor\ConfigExporter;
use lenz\contentfield\Plugin;
use lenz\contentfield\services\definitions\CKEditorConfigDefinitions;
use Symfony\Component\Yaml\Yaml;
use Throwable;
use yii\console\ExitCode;

/**
 * Manages the CKEditor configs used by `ckeditor` content fields.
 */
class CkeController extends Controller
{
  /**
   * @var bool Whether to replace legacy uid references with config names.
   */
  public bool $fix = false;

  /**
   * @var string|null A directory containing legacy config files
   * (e.g. an old copy of `config/project/ckeditor/configs`) to export from.
   */
  public ?string $path = null;

  /**
   * Matches `ckeConfig: <value>` within YAML definitions and template front matter.
   */
  const REFERENCE_PATTERN = '/(ckeConfig[\'"]?\s*:\s*)([\'"]?)([A-Za-z0-9_\-\/]+)\2/';


  /**
   * @inheritDoc
   */
  public function options($actionID): array {
    $options = parent::options($actionID);
    if ($actionID === 'check') {
      $options[] = 'fix';
    } elseif ($actionID === 'export') {
      $options[] = 'path';
    }

    return $options;
  }

  /**
   * Checks all `ckeConfig` references in `config/content` and the site
   * templates, use `--fix` to replace legacy uid references with the names
   * of the exported configs.
   *
   * @return int
   */
  public function actionCheck(): int {
    $configs = Plugin::getInstance()->ckeConfigs;
    $names = array_flip($configs->getNames());
    $problems = 0;
    $fixed = 0;

    foreach ($this->getReferenceFiles() as $file) {
      $contents = file_get_contents($file);
      if ($contents === false || !str_contains($contents, 'ckeConfig')) {
        continue;
      }

      $relative = $this->getRelativePath($file);
      $changed = preg_replace_callback(
        self::REFERENCE_PATTERN,
        function(array $match) use ($configs, $contents, $names, $relative, &$fixed, &$problems) {
          [$full, $offset] = $match[0];
          $prefix = $match[1][0];
          $quote = $match[2][0];
          $value = $match[3][0];
          $line = substr_count($contents, "\n", 0, $offset) + 1;
          $location = "$relative:$line";

          if (isset($names[$value])) {
            return $full;
          }

          if (!CKEditorConfigDefinitions::isUid($value)) {
            $problems++;
            $this->stderr("✗ $location: unknown config `$value`\n", Console::FG_RED);
            return $full;
          }

          $name = $configs->findNameByUid($value);
          if (is_null($name)) {
            $problems++;
            $this->stderr("✗ $location: legacy config `$value` has not been exported, run `contentfield/cke/export`\n", Console::FG_RED);
            return $full;
          }

          if (!$this->fix) {
            $problems++;
            $this->stdout("! $location: legacy config `$value`, should be `$name`\n", Console::FG_YELLOW);
            return $full;
          }

          $fixed++;
          $this->stdout("✓ $location: `$value` → `$name`\n", Console::FG_GREEN);
          return $prefix . $quote . $name . $quote;
        },
        $contents,
        flags: PREG_OFFSET_CAPTURE
      );

      if ($changed !== null && $changed !== $contents) {
        FileHelper::writeToFile($file, $changed);
      }
    }

    if ($problems > 0) {
      $this->stdout(sprintf(
        "\n%d problem(s) found%s.\n",
        $problems,
        $this->fix ? '' : ', run with `--fix` to replace legacy references'
      ), Console::FG_RED);

      return ExitCode::UNSPECIFIED_ERROR;
    }

    $this->stdout($fixed > 0
      ? "\nReplaced $fixed legacy reference(s).\n"
      : "All CKEditor config references are fine.\n",
      Console::FG_GREEN
    );

    return ExitCode::OK;
  }

  /**
   * Exports legacy CKEditor configs (craftcms/ckeditor < 5) to `config/content/cke`.
   * Reads from the project config, or from a directory of legacy config files
   * passed with `--path`, e.g. a copy of `config/project/ckeditor/configs`
   * restored from git: `git archive <rev> config/project/ckeditor | tar -x -C /tmp/old`.
   *
   * @return int
   */
  public function actionExport(): int {
    try {
      $configs = is_null($this->path)
        ? Craft::$app->getProjectConfig()->get('ckeditor.configs')
        : $this->readLegacyFiles($this->path);
    } catch (Throwable $error) {
      $this->stderr($error->getMessage() . "\n", Console::FG_RED);
      return ExitCode::UNSPECIFIED_ERROR;
    }

    if (empty($configs) || !is_array($configs)) {
      $this->stdout("No legacy CKEditor configs found.\n", Console::FG_YELLOW);
      return ExitCode::OK;
    }

    $exported = ConfigExporter::export($configs);
    foreach ($exported as $uid => $name) {
      $this->stdout("✓ $uid → config/content/cke/$name.yml\n", Console::FG_GREEN);
    }

    $skipped = count($configs) - count($exported);
    if ($skipped > 0) {
      $this->stdout("$skipped config(s) had already been exported.\n");
    }

    return ExitCode::OK;
  }


  // Private methods
  // ---------------

  /**
   * @return string[]
   */
  private function getReferenceFiles(): array {
    $files = [];
    $sources = [
      Craft::$app->getConfig()->configDir . DIRECTORY_SEPARATOR . 'content' => ['*.yml', '*.yaml'],
      Craft::$app->getPath()->getSiteTemplatesPath() => ['*.twig', '*.html', '*.yml', '*.yaml'],
    ];

    foreach ($sources as $path => $patterns) {
      if (is_dir($path)) {
        array_push($files, ...FileHelper::findFiles($path, ['only' => $patterns]));
      }
    }

    sort($files);
    return $files;
  }

  /**
   * @param string $file
   * @return string
   */
  private function getRelativePath(string $file): string {
    $base = Craft::getAlias('@root') . DIRECTORY_SEPARATOR;
    return str_starts_with($file, $base) ? substr($file, strlen($base)) : $file;
  }

  /**
   * @param string $path
   * @return array
   */
  private function readLegacyFiles(string $path): array {
    if (!is_dir($path)) {
      throw new \InvalidArgumentException("The directory `$path` does not exist.");
    }

    $configs = [];
    foreach (FileHelper::findFiles($path, ['only' => ['*.yaml', '*.yml']]) as $file) {
      $uid = pathinfo($file, PATHINFO_FILENAME);
      $data = Yaml::parseFile($file);

      if (CKEditorConfigDefinitions::isUid($uid) && is_array($data)) {
        $configs[$uid] = $data;
      }
    }

    return $configs;
  }
}
