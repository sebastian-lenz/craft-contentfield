---
sidebarDepth: 2
---

# Template schemas

A twig template can become a schema within the content field by prepending
a yaml header. We use three dashes `---` to separate the yaml part from the
twig part within the file. The file itself must be placed inside your regular
template directory.

A template schema that defines the fields "title" and "body" would look like
this:

**templates/example.twig**

```twig
label: Example
fields:
  title:
    type: text
  body:
    type: redactor
---
<div class="container">
  <h1>{{ title }}</h1>
  {{ body }}
</div>
```

The qualifier of a template looks like this:

```
template:{PATH/FILENAME}
```

The complete qualifier for the schema defined in the first example would be
`template:example`.

## Attributes

### `constants`

Defines one or multiple constants on the schema. Constants can be accessed
within the template like a variable:

```twig{2-3}
label: Constants example
constants:
  myConstant: A constant value
---
<h1>{{ myConstant }}</h1>
```

Constants can be used to attach data to instances and are especially helpful
in situations where the used schema can change, e.g. on an
[array](/fields/array.md) or [instance](/fields/instance.md) field.

<div class="tcfGrid--row">
  <div class="tcfGrid--col-6">

**templates/blocks/type-a.twig**

```twig{2-3}
label: Block A
constants:
  myCssClassName: block-a-class
---
<h1>Block A</h1>
```

  </div>
  <div class="tcfGrid--col-6">

**templates/blocks/type-b.twig**

```twig{2-3}
label: Block B
constants:
  myCssClassName: block-b-class
---
<h1>Block B</h1>
```

  </div>
</div>

**templates/blocks.twig**

```twig{7}
label: Blocks
fields:
  myBlock:
    type: instance
    schemas: templates/blocks/*
---
<div class="{{ myBlock.myCssClassName }}">
  {% display myBlock %}
</div>
```

### `fields`

Defines the fields attached to the schema. Must be an object hash, the keys
define the internal field names. For a complete list of available fields,
see [fields](/fields/).

```twig{2-6}
label: Fields example
fields:
  title:
    type: text
  body:
    type: redactor
---
<div class="container">
  <h1>{{ title }}</h1>
  {{ body }}
</div>
```

If only the field type needs to be specified, a shorthand synatx is available.
The field declarations above can be rewitten like this:

```twig{2-4}
label: Fields example
fields:
  title: text
  body: redactor
```

### `grid`

Defines a css grid layout for this schema. Can be used in combination with field
groups to create more complex field layouts within the control panel.

```twig{2-3,9,14}
label: Grid example
grid: >
  "left right" / 3fr 2fr
fields:
  fieldA:
    type: text
    group:
      label: My left group title
      gridArea: left
  fieldB:
    type: text
    group:
      label: My right group title
      gridArea: right
```

The attribute `grid` is a shorthand alias of the attribute `style`. The following
`style` value has the exact same effect as the example above:

```twig{2-5}
label: Grid example
style:
  medium:
    grid: >
      "left right" / 3fr 2fr
fields:
  ...
```

### `icon`

The name of the icon that represents this schema in the control panel.

```twig{2}
label: Icon example
icon: material:flight
```

::: tip
The content field installs a utility page in the control panel that displays all
available icons. Visit `Utilities` > `Content field utilities` and select the
tab `Icons`.
:::

### `label`

A human readable name of this schema. Can be translated using the `site`
translation table.

```twig{1}
label: Label example
```

### `model`

The fully qualified name of a PHP model class that should be attached
to this schema. The instance of the model class can be accessed using
the `model` variable. For more details on how to work with models,
please see [models](/guide/models.md).

```twig{2,5}
label: Model example
model: modules\models\MyModel
---
<ul>
  {% for attribute in model.attributes %}
    <li>{{ attribute }}</li>
  {% endfor %}
</ul>
```

### `preview`

A handlebars template used to create previews of this schema in the editor.

```twig{2-6}
label: Preview example
preview: >
  <dl>
    <dt>{{ image }}</dt>
    <dd>{{ title }}</dd>
  </dl>
fields:
  title:
    type: text
  image:
    type: image
---
<h1>{{ title }}</h1>
{{ image.imageTag() }}
```

### `previewImage`

The name of an asset reference field whose image will be used as an
replacement of the icon the header.

When omitted, we have a series of possible candidates that will be
used automatically (`AbstractSchema::PREVIEW_IMAGE_CANDIDATES`).

```twig{2}
label: Preview image example
previewImage: myImage
fields:
  myImage:
    type: image
```

### `previewLabel`

A template for a short text displayed in the header of an instance
next to the type name.

```twig{2-3}
label: Preview label example
previewLabel: >
  {{ primaryTitle }}
fields:
  primaryTitle: text
```

When omitted, we have a series of possible candidates that will be
used automatically (`AbstractSchema::PREVIEW_LABEL_CANDIDATES`).
Otherwise the preview will be used.

Can be set to the name of a single field as a shorthand:

```twig{2}
label: Preview label example
previewLabel: primaryTitle
fields:
  primaryTitle: text
```

### `rootSchema`

Marks this schema as a root schema. Only used to tidy up the field settings
within the control panel.

### `style`

Defines css styles applied to the form in the control panel. The following css
attributes can be set:

`alignContent`, `alignItems`, `grid`, `gridAutoColumns`, `gridAutoFlow`,
`gridAutoRows`, `gridColumnGap`, `gridGap`, `gridRowGap`, `gridTemplate`,
`gridTemplateAreas`, `gridTemplateColumns`, `gridTemplateRows`,
`justifyContent`, `justifyItems`, `placeContent`, `placeItems`

```twig{2-4}
label: Style example
style:
  alignContent: center
  alignItems: center
```

The control panel form reacts to the available width and cycles through the
resposive states `small`, `medium` and `large`. All css attributes are assigned
to the breakpoint `medium` by default. To apply certain css properties
only at certain responsive states, group them by the matching state name.

```twig{2-11}
label: Responsive style example
style:
  medium:
    grid: >
      "first second" auto
      "third third" auto
      / 1fr 1fr
  large:
    grid: >
      "first second third"
      / 1fr 1fr 1fr
```

## Templating

The twig section of the template contains regular twig markup. All functions,
filters and globals defined by Craft CMS are available within content field
templates. Furthermore, the following variables are exposed on the context of
a twig template rendered by the content field:

### Constants

All [constants](#constants) are exposed as variables to the template.

```twig{5}
label: Constants example
constants:
  myConstant: A constant value
---
<h1>{{ myConstant }}</h1>
```

### Fields

All [fields](#fields) are exposed as variables to the template. Depending on the
field type, some fields expose simple PHP types like strings and numbers to the
template while other field types might expose more complex data structures. Please refer
to the documentation of the individual field types for more information on the
exposed data types.

```twig{6}
label: Fields example
fields:
  myTitle:
    type: text
---
<h1>{{ myTitle }}</h1>
```

### `editAttributes`

The variable `editAttributes` contains prerendered html attributes that can be attached
to an element. When an user opens the live preview in the control panel, those elements
will become inetractive and can be edited directly within the preview panel.

```twig{6}
label: Live preview example
fields:
  body:
    type: redactor
---
<div class="container"{{ editAttributes }}>
  {{ body }}
</div>
```

### `instance`

The variable `instance` contains a reference to the [instance](/guide/#instances) that
is currently beeing rendered. Please refer to the documentation of the
[instance field](/fields/instance.md#templating) for more details on the available methods.

```twig{3}
label: Instance variable example
---
{% if instance.hasParentInstance('template:chapter') %}
  ...
{% endif %}
```

### `isChunkRequest`

The variable `isChunkRequest` contains a boolean value which indicates whether the current
request is a chunk request. Chunk requests allow partial rendering of content fields, please
see [chunk requests](models.md#chunkrequests).

```twig{3}
label: Chunk request example
---
{% if isChunkRequest %}
  ...
{% endif %}
```

### `loop`

The variable `loop` contains information about the position of the current instance within an
array while it is rendered. It exposes the same attributes as the twig `loop`
[variable](https://twig.symfony.com/doc/2.x/tags/for.html#the-loop-variable).

```twig{4-5,7}
label: Loop example
---
<div class="
  {{- loop.first ? 'first-block-class' : '' -}}
  {{- loop.last ? 'last-block-class' : '' -}}
">
  <h1>Loop index #{{ loop.index }}</h1>
</div>
```

::: warning
The variable `loop` is guaranteed to exist but will only contain meaningful data if

- The instance is placed inside an [array field](/fields/array.md).
- The containing array field is displayed using the `{% display %}` tag.

```twig
{% display myInstanceArray %}
```

:::

::: tip
If you use a `{% for %}` loop to render instances, you can pass the twig `loop`
variable to the render function in order to achieve a consistent behavior of
the `loop` variable.

```twig
{% for instance in myInstanceArray %}
  {{ instance.html({
    loop: loop,
  }) }}
{% endfor %}
```

:::

### `model`

The variable `model` exposes the model instance accociated with the current
schema instance to the template. For more details on how to work with models,
please see [models](/guide/models.md).

```twig{5}
label: Model example
model: modules\models\MyModel
---
<ul>
  {% for attribute in model.attributes %}
    <li>{{ attribute }}</li>
  {% endfor %}
</ul>
```
