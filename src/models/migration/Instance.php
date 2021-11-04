<?php

namespace lenz\contentfield\models\migration;

use Exception;
use lenz\contentfield\models\values\InstanceValue;
use lenz\contentfield\Plugin;
use Throwable;
use yii\helpers\Markdown;

/**
 * Class Instance
 */
class Instance
{
  /**
   * @var array
   */
  private $_attributes = [];


  /**
   * MigrationModel constructor.
   *
   * @param array $attributes
   */
  public function __construct(array $attributes) {
    $this->setAttributes($attributes);
  }

  /**
   * Converts the given attribute to a html value. If the conversion
   * fails, the attribute will be set to the given default value.
   *
   * Useful if you had a text / textarea field in your schema and
   * want to turn it into an redactor field. Uses parsedown to convert
   * text to html.
   *
   * @param string $name
   * @param string $defaultValue
   * @return $this
   */
  public function convertToHtml(string $name, string $defaultValue = ''): Instance {
    if ($this->hasAttribute($name)) {
      try {
        $text = (string)$this->getAttribute($name);
        $html = Markdown::process($text);
        $this->setAttribute($name, $html);
      } catch (Throwable $error) {
        $this->setAttribute($name, $defaultValue);
      }
    }

    return $this;
  }

  /**
   * Converts the given attribute to a string value. If the conversion
   * fails, the attribute will be set to the given default value.
   *
   * @param string $name
   * @param string $defaultValue
   * @return $this
   */
  public function convertToString(string $name, string $defaultValue = ''): Instance {
    if ($this->hasAttribute($name)) {
      try {
        $text = (string)$this->getAttribute($name);
        $text = strip_tags($text);
        $this->setAttribute($name, $text);
      } catch (Throwable $error) {
        $this->setAttribute($name, $defaultValue);
      }
    }

    return $this;
  }

  /**
   * Makes sure the attribute with the given name is set. If it
   * is missing, it will be set to the given value.
   *
   * @param string $name
   * @param mixed $value
   * @return $this
   */
  public function ensureAttribute(string $name, $value): Instance {
    if (!$this->hasAttribute($name)) {
      $this->setAttribute($name, $value);
    }

    return $this;
  }

  /**
   * Returns a collection of all instances within this
   * instance including this instance.
   *
   * @param string|array|null $qualifier
   * @return Collection
   * @throws Throwable
   */
  public function find($qualifier = null): Collection {
    return $this
      ->findInstances()
      ->append($this)
      ->matchesQualifier($qualifier);
  }

  /**
   * Returns a collection of all child instances of this
   * instance.
   *
   * @param string|array|null $qualifier
   * @return Collection
   * @throws Throwable
   */
  public function findChildren($qualifier = null): Collection {
    $collection = new Collection();

    foreach ($this->_attributes as $value) {
      if (is_array($value)) {
        foreach ($value as $item) {
          if ($item instanceof Instance) {
            $collection->append($item);
          }
        }
      } else if ($value instanceof Instance) {
        $collection->append($value);
      }
    }

    return $collection->matchesQualifier($qualifier);
  }

  /**
   * Returns a collection of all child instances of this
   * instance including this instance.
   *
   * @param string|array|null $qualifier
   * @return Collection
   * @throws Throwable
   * @noinspection PhpUnused (Public API)
   */
  public function findChildrenAndSelf($qualifier = null): Collection {
    return $this
      ->findChildren()
      ->append($this)
      ->matchesQualifier($qualifier);
  }

  /**
   * Return a collection of all instances which contained inside
   * this instance. Similar to `Instance::children` but returns child
   * instances at any depth.
   *
   * @param string|array|null $qualifier
   * @return Collection
   * @throws Throwable
   */
  public function findInstances($qualifier = null): Collection {
    $collection = new Collection();
    $this->findChildren()->each(function(Instance $child) use ($collection) {
      $collection->merge($child->find());
    });

    return $collection->matchesQualifier($qualifier);
  }

  /**
   * @param string $name
   * @return mixed
   */
  public function getAttribute(string $name) {
    return !array_key_exists($name, $this->_attributes)
      ? null
      : $this->_attributes[$name];
  }

  /**
   * @return array
   */
  public function getSerializedValue(): array {
    return $this->serializeRecursive($this->_attributes);
  }

  /**
   * @return string|null
   */
  public function getType(): ?string {
    $type = $this->getAttribute(InstanceValue::TYPE_PROPERTY);
    return is_null($type) ? null : (string)$type;
  }

  /**
   * @return bool
   */
  public function getVisibility(): bool {
    $visibility = $this->getAttribute(InstanceValue::VISIBLE_PROPERTY);
    return is_null($visibility) || !!$visibility;
  }

  /**
   * @param string $name
   * @return bool
   */
  public function hasAttribute(string $name): bool {
    return array_key_exists($name, $this->_attributes);
  }

  /**
   * @param string|string[] $specs
   * @return boolean
   * @throws Throwable
   */
  public function matchesQualifier($specs): bool {
    return Plugin::getInstance()
      ->schemas
      ->matchesQualifier($this->getType(), $specs);
  }

  /**
   * Modifies the attribute with the given name by using the given
   * callback function.
   *
   * @param string $name
   * @param callable $callback
   * @return $this
   */
  public function modifyAttribute(string $name, callable $callback): Instance {
    if ($this->hasAttribute($name)) {
      $this->setAttribute($name, $callback($this->getAttribute($name)));
    }

    return $this;
  }

  /**
   * @param array $replacements
   * @return $this
   */
  public function renameAttribute(array $replacements): Instance {
    foreach ($replacements as $oldName => $newName) {
      if ($this->hasAttribute($oldName)) {
        $this->setAttribute($newName, $this->getAttribute($oldName));
        $this->removeAttribute($oldName);
      }
    }

    return $this;
  }

  /**
   * Renames the type of this instance using the given
   * replacement map.
   *
   * @param array $replacements
   * @return $this
   * @throws Exception
   */
  public function renameType(array $replacements): Instance {
    $type = $this->getType();

    foreach ($replacements as $oldType => $newType) {
      if ($type == $oldType) {
        $this->setType($newType);
        break;
      }
    }

    return $this;
  }

  /**
   * @param string $name
   * @return $this
   */
  public function removeAttribute(string $name): Instance {
    unset ($this->_attributes[$name]);
    return $this;
  }

  /**
   * Sets an attribute on this instance.
   *
   * @param string $name
   * @param mixed $value
   * @return $this
   */
  public function setAttribute(string $name, $value): Instance {
    if (self::isInstance($value)) {
      $value = new Instance($value);
    } elseif (is_array($value)) {
      $value = array_map(function($item) {
        return self::isInstance($item)
          ? new Instance($item)
          : $item;
      }, $value);
    }

    $this->_attributes[$name] = $value;
    return $this;
  }

  /**
   * Sets multiple attributes on this instance.
   *
   * @param array $attributes
   * @return $this
   */
  public function setAttributes(array $attributes): Instance {
    foreach ($attributes as $name => $value) {
      $this->setAttribute($name, $value);
    }

    return $this;
  }

  /**
   * Sets the type of this instance.
   *
   * @param string $qualifier
   * @return $this
   * @throws Exception
   */
  public function setType(string $qualifier): Instance {
    $parsed = Plugin::getInstance()
      ->schemas
      ->parseSchemaQualifier($qualifier);

    $this->setAttribute(InstanceValue::TYPE_PROPERTY, $parsed['uri']);
    return $this;
  }

  /**
   * @param bool $value
   * @return $this
   */
  public function setVisibility(bool $value): Instance {
    $this->setAttribute(InstanceValue::VISIBLE_PROPERTY, $value);
    return $this;
  }


  // Private methods
  // ---------------

  /**
   * @param array $value
   * @return array
   */
  private function serializeRecursive(array $value): array {
    return array_map(function($item) {
      if ($item instanceof Instance) {
        return $item->getSerializedValue();
      } elseif (is_array($item)) {
        return $this->serializeRecursive($item);
      }

      return $item;
    }, $value);
  }


  // Static methods
  // --------------

  /**
   * @param string $qualifier
   * @param array $attributes
   * @return Instance
   * @throws Exception
   */
  static function create(string $qualifier, array $attributes): Instance {
    $parsed = Plugin::getInstance()
      ->schemas
      ->parseSchemaQualifier($qualifier);

    return new Instance(array_merge([
      InstanceValue::TYPE_PROPERTY => $parsed['uri'],
      InstanceValue::UUID_PROPERTY => InstanceValue::uuid(),
      InstanceValue::ORIGINAL_UUID_PROPERTY => null,
      InstanceValue::VISIBLE_PROPERTY => true,
    ], $attributes));
  }

  /**
   * @param mixed $value
   * @return bool
   */
  static function isInstance($value): bool {
    return (
      is_array($value) &&
      array_key_exists(InstanceValue::TYPE_PROPERTY, $value) &&
      array_key_exists(InstanceValue::UUID_PROPERTY, $value)
    );
  }
}
