---
sidebarDepth: 2
attributes:
  - name: defaultValue
    description: The key of the preselected value.
  - name: options
    description: Defines the available static options.
  - name: enumeration
    description: >
      The qualifier of an enumeration class that defines the available
      options. Used to programmatically declare options.
---

# Select field

The select field allows the editor to select one of several predefined
options from a dropdown.

```yaml
simpleSelect:
  type: select
  label: My simple select
  options:
    firstKey: My first option
    secondKey: My second option
```

This field definition creates the following input in the control panel:

![A select field in the control panel](./images/select-field-01.png)

## Attributes

<tcf-field-attribs :attributes="$page.frontmatter.attributes" />

### `defaultValue`

The key of the preselected value.

```yaml
defaultValue: firstKey
```

### `options`

Defines the available static options. This can be given as a simple hash map.

```yaml
options:
  firstKey: My first option
  secondKey: My second option
```

You can also specify the available options as an array of objects each
containing a :code:`key` and :code:`label` value. The above example
produces the identical result as the following notation:

```yaml
options:
  - key: firstKey
    label: My first option
  - key: secondKey
    label: My second option
```

This notation allows you to attach additional values to each option which
can be accessed inside your template:

```twig
label: Option extra values demo
fields:
selectField:
  type: select
  options:
  - key: firstKey
    label: My first option
    className: firstCssClass
  - key: secondKey
    label: My second option
    className: secondCssClass
---
<div class="{{ selectField.className }}">
  {{ selectField.label }}
</div>
```

## `enumeration`

The qualifier of an enumeration class that defines the available
options. Used to programmatically declare options, override any
static options.

```yaml
enumeration: myModule\DemoEnumeration
```

You must declare a php class implementing the interface
`EnumerationInterface`. The `getOptions` must return
the available options as `key` / `label` pairs.

```php
<?php

namespace myModule;
use lenz\contentfield\models\enumerations\EnumerationInterface;

class DemoEnumeration implements EnumerationInterface
{
  /**
    * Return an array of all options.
    * @return array
    */
  public function getOptions() {
    return [
      [
        'key'   => 'first'
        'label' => 'My first option'
      ],
      [
        'key'   => 'second'
        'label' => 'My second option'
      ],
    ];
  }
}
```

## Templating

Printing the select field will return the key of the selected option.

```twig
label: Select field demo
fields:
  selectField:
  type: select
  options:
    firstKey: My first option
    secondKey: My second option
---
{{ selectField }}
```

You can access the properties of the selected item:

```twig
{{ selectField.label }}
```
