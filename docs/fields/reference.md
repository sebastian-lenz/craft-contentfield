---
sidebarDepth: 2
attributes:
  - name: criteria
    description: >
      Specifies additional filter criteria for the selectable elements.
  - name: elementType
    required: true
    description: >
      The element class selected by the field, e.g.
      :code:`craft\elements\Asset`.
  - name: limit
    description: >
      The maximum number of references allowed.
  - name: sources
    description: >
      A list of sources the entry can be picked from.
  - name: viewMode
    description: >
      The view mode the input should use in the control panel. Must
      be either :code:`large` or :code:`small`.
---

# Reference field

The reference field allows the editor to select other elements like
entries or assets.

```yaml
myReferenceField:
  type: reference
  elementType: entry
```

This field definition creates the following input in the control panel:

![A reference field in the control panel](./images/reference-field-01.png)

::: tip
We provide several aliases of the reference field for asset and
entry references, please see [aliases](#aliases).
:::

## Attributes

<tcf-field-attribs :attributes="$page.frontmatter.attributes" />

### `criteria`

Specifies additional filter criteria for the selectable elements. The
available filter criteria depend on the selected element type, we only
list the most commonly used criteria here.

#### `kind`

Allows you to specify the asset kind the user is allowed to select.
Craft defines the following file kinds:

- access
- audio
- compressed
- excel
- flash
- html
- illustrator
- image
- javascript
- json
- pdf
- photoshop
- php
- powerpoint
- text
- video
- word
- xml
- unknown

```yaml
criteria:
  kind:
    - image
    - video
```

### `elementType`

The element class selected by the field. This can be any valid element
class, both from the core or from other plugins.

```yaml
elementType: craft\elements\Asset
```

The Craft CMS defines the following element classes:

- craft\\elements\\Asset
- craft\\elements\\Category
- craft\\elements\\Entry
- craft\\elements\\GlobalSet
- craft\\elements\\Tag
- craft\\elements\\User

### `limit`

The maximum number of references allowed.

```yaml
limit: 1
```

### `sources`

A list of sources the entry can be picked from. The available options depend
on the selected :code:`elementType`. For entry elements this usually controls
which sections are available, for assets it controls which folders are available.

```yaml
sources:
  - section:560258d5-d8a0-4625-bcd2-11ed7ff1b225
```

::: tip
The content field includes a utility page that lists all sources of the
common entry types, in the control panel visit :code:`Utilities` >
:code:`Content field utilities` > :code:`Sources`.
:::

### `viewMode`

The view mode the input should use in the control panel. Must be either
:code:`large` or :code:`small`.

```yaml
viewMode: small
```

## Templating

The reference field behaves like an array within the template, you can
iterate over the selected references and receive the elements.

```twig
label: Reference field demo
fields:
  referenceField:
    type: reference
    elementType: craft\elements\Asset
---
<ul>
  {% for reference in referenceField %}
    <li>{{ reference.title }}</li>
  {% endfor %}
</ul>
```

You can also access references based on their index:

```twig
{% if referenceField|length > 0 %}
  {{ referenceField[0].title }}
{% endif %}
```

### `first` / `getFirst`

The first helper allows you to quickly receive the first element.

```twig
{% if referenceField.hasValue %}
  {{ referenceField.first.title }}
{% endif %}
```

### `imageTag`

The image tag helper allows you to render an asset reference as an
image tag. To learn more about how image tags work, see
:doc:`../advanced/image-tags`.

```twig
  {{ referenceField.imageTag('image-config-name') }}
```

## Aliases

The reference field provides several aliases for commonly used field
configurations.

### `entry`

Allows the editor to pick one entry.

```yaml
entryField:
  type: entry
```

### `entries`

Allows the editor to pick multiple entries.

```yaml
entriesField:
  type: entries
```

### `file`

Allows the editor to pick one file.

```yaml
fileField:
  type: file
```

### `files`

Allows the editor to pick multiple files.

```yaml
filesField:
  type: files
```

### `image`

Allows the editor to pick one image.

```yaml
imageField:
  type: image
```

### `images`

Allows the editor to pick multiple images.

```yaml
imagesField:
  type: images
```
