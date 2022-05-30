<?php

namespace lenz\contentfield\models\schemas;

use Craft;
use craft\base\ElementInterface;
use craft\elements\Asset;
use craft\helpers\ArrayHelper;
use Error;
use Exception;
use lenz\contentfield\behaviors\AnchorBehaviour;
use lenz\contentfield\events\BeforeActionEvent;
use lenz\contentfield\models\Content;
use lenz\contentfield\models\fields\AbstractField;
use lenz\contentfield\models\fields\ReferenceField;
use lenz\contentfield\models\values\InstanceValue;
use lenz\contentfield\Plugin;
use lenz\contentfield\validators\ValueValidator;
use Throwable;
use yii\base\Model;
use yii\helpers\Inflector;

/**
 * Class AbstractSchema
 *
 * Base class of all schemas.
 */
abstract class AbstractSchema extends Model
{
  /**
   * The name of the field(s) that declare the name of the anchor exposed by
   * this instance. The value of the first non-empty field will be used.
   * @var string|string[]|null
   */
  public string|array|null $anchor = null;

  /**
   * Custom data attached to this schema.
   * @var array
   */
  public array $constants = [];

  /**
   * A list of all fields attached to this schema.
   * @var AbstractField[]
   */
  public array $fields = [];

  /**
   * Defines the css grid layout of this schema. Grid layout is used
   * to place the field groups within the schema form.
   *
   * This is a shorthand for:
   * ```
   * style:
   *   medium:
   *     grid: <value>
   * ```
   *
   * @var string|array|null
   */
  public string|array|null $grid = null;

  /**
   * The name of the icon that represents this schema.
   * @var string|null
   */
  public string|null $icon = null;

  /**
   * A human-readable name of this schema.
   * @var string
   */
  public string $label;

  /**
   * @var string
   */
  public string $mimeType = 'text/html';

  /**
   * The fully qualified name of the model class that should be attached
   * to this schema.
   *
   * @var string|null
   */
  public ?string $model = null;

  /**
   * A handlebars template used to display instances of this schema in the editor.
   *
   * @var string|null
   */
  public ?string $preview = null;

  /**
   * The name of an asset reference field whose image will be used as an
   * replacement of the icon the header.
   *
   * When omitted, we have a series of possible candidates that will be
   * used automatically (AbstractSchema::PREVIEW_IMAGE_CANDIDATES).
   *
   * ```
   * previewImage: imageField
   * ```
   *
   * @var string
   */
  public string $previewImage;

  /**
   * A template for a short text displayed in the header of an instance
   * next to the type name.
   *
   * When omitted, we have a series of possible candidates that will be
   * used automatically (AbstractSchema::PREVIEW_LABEL_CANDIDATES).
   * Otherwise the preview will be used.
   *
   * Can be set to the name of a single field as a shorthand:
   * ```
   * previewLabel: primaryTitle
   * ```
   *
   * @var string
   */
  public string $previewLabel;

  /**
   * Marks this schema as a root schema. Only used to tidy up the cp field settings.
   * @var bool
   */
  public bool $rootSchema = false;

  /**
   * The css styles applied to form of this instance, grouped by breakpoint.
   * @var array
   */
  public array $style;

  /**
   * The internal name of this schema.
   * @var string
   */
  public string $qualifier;

  /**
   * The default icon to use if no icon is specified.
   */
  const DEFAULT_ICON = 'material:check_box_outline_blank';

  /**
   * List of allowed style attributes.
   */
  const STYLE_ATTRIBUTES = [
    'alignContent',
    'alignItems',
    'grid',
    'gridAutoColumns',
    'gridAutoFlow',
    'gridAutoRows',
    'gridColumnGap',
    'gridGap',
    'gridRowGap',
    'gridTemplate',
    'gridTemplateAreas',
    'gridTemplateColumns',
    'gridTemplateRows',
    'justifyContent',
    'justifyItems',
    'placeContent',
    'placeItems',
  ];

  /**
   * A list of fields we consider using as the image preview field.
   */
  const PREVIEW_IMAGE_CANDIDATES = [
    'image',
    'icon'
  ];

  /**
   * A list of fields we consider using as the label preview field.
   */
  const PREVIEW_LABEL_CANDIDATES = [
    'title',
    'primaryTitle',
    'heading',
    'headline',
    'label',
    'body'
  ];


  /**
   * AbstractSchema constructor.
   *
   * @param array $config
   * @throws Exception
   */
  public function __construct(array $config = []) {
    if (!isset($config['qualifier'])) {
      throw new Exception('All schemas must have a qualifier.');
    } else {
      // Set the qualifier early so we can use it in error messages
      $this->qualifier = $config['qualifier'];
    }

    if (!isset($config['label'])) {
      $config['label'] = $this->generateSchemaLabel($config['qualifier']);
    }

    if (isset($config['fields'])) {
      foreach ($config['fields'] as $key => $field) {
        $this->addField($key, $field);
      }

      unset($config['fields']);
    }

    parent::__construct($config);
  }

  /**
   * Makes this schema take over the rendering of the current request.
   *
   * @param BeforeActionEvent $event
   * @param Content $content
   */
  abstract function applyPageTemplate(BeforeActionEvent $event, Content $content): void;

  /**
   * Displays this schema.
   *
   * @param InstanceValue $instance
   * @param array $variables
   */
  public function display(InstanceValue $instance, array $variables = []): void {
    echo $this->render($instance, $variables);
  }

  /**
   * @param string $name
   * @param mixed|null $default
   * @return mixed
   */
  public function getConstant(string $name, mixed $default = null): mixed {
    return array_key_exists($name, $this->constants)
      ? $this->constants[$name]
      : $default;
  }

  /**
   * Return a list of all schemas this schema depends on, e.g.
   * when another schema is used by a field.
   *
   * @return AbstractSchema[]
   */
  public function getDependedSchemas(): array {
    $result = [];

    foreach ($this->fields as $field) {
      $schemas = $field->getDependedSchemas();
      if (!is_null($schemas)) {
        $result += $schemas;
      }
    }

    return $result;
  }

  /**
   * Return the data of this schema as required by the js editor.
   *
   * @param ElementInterface|null $element
   * @return array
   */
  public function getEditorData(ElementInterface $element = null): array {
    $fields = [];

    foreach ($this->fields as $name => $field) {
      if (!$field->hasErrors()) {
        $fields[$name] = $field->getEditorData($element);
      }
    }

    return [
      'fields'       => $fields,
      'icon'         => $this->getIcon(),
      'label'        => Plugin::t($this->getLabel()),
      'preview'      => $this->getPreview(),
      'previewImage' => $this->getPreviewImage(),
      'previewLabel' => $this->getPreviewLabel(),
      'qualifier'    => $this->qualifier,
      'style'        => $this->getEditorStyle(),
    ];
  }

  /**
   * Return a field by name.
   *
   * @param string $name
   * @return AbstractField|null
   */
  public function getField(string $name): ?AbstractField {
    return array_key_exists($name, $this->fields)
      ? $this->fields[$name]
      : null;
  }

  /**
   * Return the name of the icon that represents this schema.
   *
   * @return string
   */
  public function getIcon(): string {
    return $this->icon ?? self::DEFAULT_ICON;
  }

  /**
   * Return the human readable name of this schema.
   *
   * @return string
   */
  public function getLabel(): string {
    return $this->label;
  }

  /**
   * @param string $name
   * @return AbstractSchema|null
   */
  abstract public function getLocalStructure(string $name): ?AbstractSchema;

  /**
   * Returns the name part of this schemas qualifier.
   *
   * @return string
   */
  public function getName(): string {
    return self::extractName($this->qualifier);
  }

  /**
   * Return the handlebars template used to preview instances of this
   * schema in the editor.
   *
   * @return string|null
   */
  public function getPreview(): ?string {
    return $this->preview;
  }

  /**
   * @return array
   */
  public function getValueRules(): array {
    $result = [];

    foreach ($this->fields as $name => $field) {
      foreach ($field->getValueRules() as $rule) {
        $validator = $rule[0];
        $useRawValue = (
          !is_subclass_of($validator, ValueValidator::class) &&
          !$field->useRawValueValidation()
        );

        $attribute = $useRawValue
          ? 'raw:' . $name
          : $name;

        unset($rule[0]);
        $result[] = [$attribute, $validator] + $rule;
      }
    }

    return $result;
  }

  /**
   * @return string
   * @throws Exception
   */
  public function getClientValidationScript(): string {
    $model      = new InstanceValue([], $this);
    $validators = [];
    $view       = Craft::$app->getView();

    foreach ($model->getActiveValidators() as $validator) {
      foreach ($validator->attributes as $attribute) {
        if (str_starts_with($attribute, 'raw:')) {
          $attribute = substr($attribute, 4);
        }

        $js = $validator->clientValidateAttribute($model, $attribute, $view);
        if ($validator->enableClientValidation && $js != '') {
          if ($validator->whenClient !== null) {
            $js = "if (($validator->whenClient)(attribute, value)) { $js }";
          }

          $validators[$attribute][] = $js;
        }
      }
    }

    $result = '';
    foreach ($validators as $name => $handlers) {
      $id = uniqid();
      $this->fields[$name]->setClientValidationId($id);
      $result .= 'lenz.contentField.registerValidator("' . $id . '", function(attribute, value, messages, deferred, $form) {' . implode('', $handlers) . '});';
    }

    return $result;
  }

  /**
   * @param string $name
   * @return bool
   */
  public function hasConstant(string $name): bool {
    return array_key_exists($name, $this->constants);
  }

  /**
   * @param string $name
   * @return bool
   */
  public function hasField(string $name): bool {
    return array_key_exists($name, $this->fields);
  }

  /**
   * @param string $name
   * @return bool
   */
  abstract public function hasLocalStructure(string $name): bool;

  /**
   * @param string|string[] $specs
   * @return boolean
   * @throws Throwable
   */
  public function matchesQualifier(array|string $specs): bool {
    return Plugin::getInstance()
      ->schemas
      ->matchesQualifier($this->qualifier, $specs);
  }

  /**
   * Renders this schema.
   *
   * @param InstanceValue $instance
   * @param array $variables
   * @param array $options
   * @return string
   */
  abstract function render(InstanceValue $instance, array $variables = [], array $options = []): string;

  /**
   * @inheritdoc
   */
  public function rules(): array {
    return [
      [['label', 'qualifier'], 'required'],
      [['icon', 'grid', 'label', 'preview', 'qualifier'], 'string'],
      ['anchor', 'validateAnchor'],
      ['constants', 'validateArray'],
      ['fields', 'validateFields'],
    ];
  }

  /**
   * @param string $attribute
   * @noinspection PhpUnused (Validator)
   */
  public function validateAnchor(string $attribute) {
    $fields = AnchorBehaviour::parseAnchorFields($this->$attribute);
    if (is_null($fields)) {
      return;
    }

    foreach ($fields as $field) {
      if (!$this->hasField($field)) {
        $this->addError($attribute, "Unknown anchor field `$field`.");
      }
    }
  }

  /**
   * @param string $attribute
   * @noinspection PhpUnused (Validator)
   */
  public function validateArray(string $attribute) {
    if (!is_array($this->$attribute)){
      $this->addError($attribute, '{attribute} must be an array.');
    }
  }

  /**
   * A validator that checks the fields of this schema.
   *
   * @param string $attribute
   * @noinspection PhpUnused (Validator)
   */
  public function validateFields(string $attribute) {
    if (!is_array($this->$attribute)) {
      $this->addError($attribute, "$attribute must be an array.");
      return;
    }

    foreach ($this->$attribute as $name => $field) {
      if (!($field instanceof AbstractField)) {
        $this->addError($attribute, "Field $name: fields must be an instances of the Field class.");
      } elseif (!$field->validate()) {
        foreach ($field->getErrors() as $errorAttribute => $errors)
        foreach ($errors as $attribute => $error) {
          $this->addError($attribute, "Field '$name', property '$errorAttribute': $error");
        }
      }
    }
  }


  // Protected methods
  // -----------------

  /**
   * @param int|string $key
   * @param array|string|AbstractField $config
   * @throws Exception
   */
  protected function addField(int|string $key, AbstractField|array|string $config): void {
    static $fieldManager = null;
    if (is_null($fieldManager)) {
      $fieldManager = Plugin::getInstance()->fields;
    }

    // If the field is already an instance, use it
    if ($config instanceof AbstractField) {
      $this->fields[$config->name] = $config;
      return;
    }

    // If the field is no an array try to load blueprint or use it
    // as the field type
    if (is_string($config)) {
      $config = ['type' => $config];
    }

    // If the field list is associative, use the keys as the field names
    if (is_string($key)) {
      if (isset($config['name'])) {
        Craft::warning(
          ['The field `$1` on schema `$2` has multiple names.', $key, $this->qualifier],
          'craft-contentfield'
        );
      }

      $config['name'] = $key;
    }

    if (
      !isset($config['type']) ||
      !isset($config['name'])
    ) {
      throw new Exception('Invalid schema');
    }

    $instance = $fieldManager->createField($this, $config);
    if (isset($this->fields[$instance->name])) {
      throw new Exception(sprintf(
        'The field `%s` is already set on schema `%s`.',
        $instance->name, $this->qualifier
      ));
    }

    $this->fields[$instance->name] = $instance;
  }

  /**
   * @param string $qualifier
   * @return string
   */
  protected function generateSchemaLabel(string $qualifier): string {
    return Inflector::camel2words(self::extractName($qualifier));
  }

  /**
   * @return array|null
   */
  protected function getEditorStyle(): ?array {
    $style = $this->style ?? [];

    if (!empty($this->grid)) {
      $style[AbstractField::DEFAULT_BREAKPOINT]['grid'] = $this->grid;
    }

    return AbstractField::createBreakpoints($style, self::STYLE_ATTRIBUTES);
  }

  /**
   * @return string|null
   */
  protected function getPreviewImage(): ?string {
    $candidates = isset($this->previewImage)
      ? [$this->previewImage]
      : self::PREVIEW_IMAGE_CANDIDATES;

    foreach ($candidates as $candidate) {
      $field = $this->getField($candidate);
      if (
        $field instanceof ReferenceField &&
        $field->elementType === Asset::class
      ) {
        return $field->name;
      }
    }

    return null;
  }

  /**
   * @return string|null
   */
  protected function getPreviewLabel(): ?string {
    if (isset($this->previewLabel) && !empty($this->previewLabel)) {
      return $this->hasField($this->previewLabel)
        ? '{{' . $this->previewLabel . '}}'
        : $this->previewLabel;
    }

    foreach (self::PREVIEW_LABEL_CANDIDATES as $candidate) {
      if ($this->hasField($candidate)) {
        return '{{' . $candidate . '}}';
      }
    }

    return null;
  }


  // Static methods
  // --------------

  /**
   * @param string $qualifier
   * @return string
   */
  public static function extractName(string $qualifier): string {
    $offset = strpos($qualifier, ':');
    if ($offset !== false) {
      $qualifier = substr($qualifier, $offset + 1);
    }

    $offset = strpos($qualifier, '@');
    if ($offset !== false) {
      $qualifier = substr($qualifier, 0, $offset);
    }

    return $qualifier;
  }

  /**
   * @param array $definitions
   * @param array $options
   * @return array
   * @throws Exception
   */
  static public function expandConfig(array $definitions, array $options = []): array {
    $triggers = [
      '.' => ['fields', ArrayHelper::getValue($definitions, 'fields', [])],
    ];

    if (array_key_exists('allowStructures', $options) && $options['allowStructures']) {
      $triggers['+'] = ['structures', ArrayHelper::getValue($definitions, 'structures', [])];
    }

    foreach ($triggers as list($name, $value)) {
      if (!is_array($value)) {
        throw new Error("The schema attribute `$name` must be an array.");
      }
    }

    $definitions = array_filter($definitions, function($value, $key) use (&$triggers) {
      if (array_key_exists($key[0], $triggers)) {
        $triggers[$key[0]][1][substr($key, 1)] = $value;
        return false;
      } else {
        return true;
      }
    }, ARRAY_FILTER_USE_BOTH);

    foreach ($triggers as list($name, $value)) {
      $definitions[$name] = $name === 'structures'
        ? array_map(function($definition) {
            return self::expandConfig($definition);
          }, $value)
        : $value;
    }

    return $definitions;
  }
}
