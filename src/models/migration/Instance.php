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
  public function convertToHtml(string $name, string $defaultValue = '') {
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
  public function convertToString(string $name, string $defaultValue = '') {
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
  public function ensureAttribute(string $name, $value) {
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
   */
  public function find($qualifier = null) {
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
   */
  public function findChildren($qualifier = null) {
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
   */
  public function findChildrenAndSelf($qualifier = null) {
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
   */
  public function findInstances($qualifier = null) {
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
  public function getSerializedValue() {
    return $this->serializeRecursive($this->_attributes);
  }

  /**
   * @return string|null
   */
  public function getType() {
    $type = $this->getAttribute(InstanceValue::TYPE_PROPERTY);
    return is_null($type) ? null : (string)$type;
  }

  /**
   * @param string $name
   * @return bool
   */
  public function hasAttribute(string $name) {
    return array_key_exists($name, $this->_attributes);
  }

  /**
   * @param string|string[] $specs
   * @return boolean
   * @throws Throwable
   */
  public function matchesQualifier($specs) {
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
  public function modifyAttribute(string $name, callable $callback) {
    if ($this->hasAttribute($name)) {
      $this->setAttribute($name, $callback($this->getAttribute($name)));
    }

    return $this;
  }

  /**
   * @param array $replacements
   * @return $this
   */
  public function renameAttribute(array $replacements) {
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
  public function renameType(array $replacements) {
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
  public function removeAttribute(string $name) {
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
  public function setAttribute(string $name, $value) {
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
  public function setAttributes(array $attributes) {
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
  public function setType(string $qualifier) {
    $parsed = Plugin::getInstance()
      ->schemas
      ->parseSchemaQualifier($qualifier);

    $this->setAttribute(InstanceValue::TYPE_PROPERTY, $parsed['uri']);
    return $this;
  }


  // Private methods
  // ---------------

  /**
   * @param array $value
   * @return array
   */
  private function serializeRecursive(array $value) {
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
   * @param mixed $value
   * @return bool
   */
  static function isInstance($value) {
    return (
      is_array($value) &&
      array_key_exists(InstanceValue::TYPE_PROPERTY, $value) &&
      array_key_exists(InstanceValue::UUID_PROPERTY, $value)
    );
  }
}
