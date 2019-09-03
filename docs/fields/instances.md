---
sidebarDepth: 2
attributes:
  - name: limit
    path: /fields/array
  - name: schemas
    path: /fields/instance
  - name: collapsible
    description: >
      Displays the list items in the control panel as collapsible cards.
      This is turned on by default.
  - name: previewMode
    description: >
      Controls the behavior of the instance previews when items are 
      collapsed. Defaults to <code>root</code>.
---

# Instances field

The instances field allows editors to create a sequence of instances.

Under the hood this is a preconfigured [array field](/fields/array.md) with an
[instanc field](/fields/instance.md) member. It therefore borrows attributes from
both the array and instance fields.

```yaml
myInstancesField:
  type: instances
  schemas:
    - path/to/template-a
    - path/to/template-b
```

This field definition creates the following input in the control panel:

![An instances field in the control panel](./images/instances-field-01.png)

## Attributes

<tcf-field-attribs />

### `collapsible`

Displays the list items in the control panel as collapsible cards.
This is turned on by default.

```yaml{3}
myInstancesField:
  type: instances
  collapsible: false
  schemas:
    - path/to/template-a
    - path/to/template-b
```

### `previewMode`

Controls the behavior of the instance previews when items are collapsed. Defaults to `root`.
Allowed values are:

- `always`: Always shows the extended preview as defined by the `preview` instance property.
- `never`: Never shows a preview, always uses `previewLabel`.
- `root`: Only show the extended preview if the array is at the first display level.

```yaml{3}
myInstancesField:
  type: instances
  previewMode: never
  schemas:
    - path/to/template-a
    - path/to/template-b
```

## Templating

The instances field exposes an instance of `lenz\contentfield\models\values\ArrayValue`
to templates.

### Array access

The class `ArrayValue` implements both the `ArrayAccess` and the `Countable` interface.
You can therefore access individual instances directly using the array access syntax and
check the length of the array using the `length` filter.

```twig
{% if myInstancesField|length > 0 %}
  <p>{{ myInstancesField[0].html }}</p>
{% endif %}
```

### `{% for %}`

The class `ArrayValue` implements the `IteratorAggregate` interface. You can therefore loop
through all instances using the default twig `for` tag.

::: tip
The default iterator will loop over all instances within the array, if you only want to iterate
over visible instances use [`getVisibleIterator`](#getvisibleiterator-visibleiterator).
:::

```twig
label: Instances field example
fields:
  myInstancesField:
    type: instances
    schemas:
      - path/to/template-a
      - path/to/template-b
---
<ul>
  {% for instance in myInstancesField %}
    <li>{{ instance.html }}</li>
  {% endfor %}
</ul>
```

### `{% display %}`

The `display` tag can be used to render all visible instances of an array.

```twig
{% display myInstancesField %}
```

### `findInstances($qualifier)`

Returns an array of all child instances that match the given qualifier. This method traverses
the entire instance tree and therefore also returns matching nested instances.

```twig
<ul>
  {% for instance in myArrayField.findInstances('template:elements/*') %}
    <li>{{ instance.uuid }}</li>
  {% endif %}
</ul>
```

### `findUuid($uuid)`

Retruns the instance with the given uuid or `null` if the instance cannot be found.

```twig
{% set instance = myArrayField.findUuid('3030271d-1185-4870-9b46-e747905c540b') %}
{% if instance %}
  <p>Found instance: {{ instance.uuid }}</p>
{% endif %}
```

### `getFirst()` / `first`

Retrieves the first visible instance of the array.

```twig
{% if myInstancesField.first %}
  {{ myInstancesField.first.html }}
{% endif %}
```

### `getHtml` / `html`

You can also use the `html` utility function to retrieve the rendered
templates as a twig html node.

```twig
{{ instancesField.html }}
```

The `html` utility function allows you to pass additional template
variables:

```twig
{{ instancesField.html({
    extraValue: 'Some value'
  }) }}
```

### `getValues()` / `values`

Returns a native PHP array containing the instances.

```twig
{% set nativeArray = myInstancesField.values %}
```

### `hasValue()` / `isEmpty()`

Checks whether the array contains any instances.

```twig
{% if myInstancesField.hasValue %}
  ...
{% endif %}
```

### `getVisibleIterator()` / `visibleIterator`

Returns an iterator that only loops over visible items.
