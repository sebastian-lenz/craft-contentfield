---
sidebarDepth: 2
attributes:
  - name: allowNewWindow
    description: >
      Whether the option top open links in new a new window should
      be shown. Defaults to true.
  - name: linkTypes
    description: >
      Defines the available link types. By default this contains definitions
      for url, mail, entry and asset links.
---

# Link field

The link field allows editors to create a link to another element or an
external url.

```yaml
simpleLinkField:
  type: link
  label: My simple link
```

This field definition creates the following input in the control panel:

![A link field in the control panel](./images/link-field-01.png)

## Attributes

<tcf-field-attribs :attributes="$page.frontmatter.attributes" />

### `allowNewWindow`

Whether the option top open links in new a new window should be shown.
Defaults to true.

```yaml
allowNewWindow: false
```

### `linkTypes`

Defines the available link types. By default this contains definitions
for url, mail, entry and asset links. This value must be an object,
the keys define the internal link names and the values must contain the
link definitions.

```yaml
linkTypes:
  url:
    type: input
    inputType: url
    label: Url
  entry:
    type: element
    elementType: craft\elements\Entry
    label: Entry
```

There are two types of supported link input methods: `element`
and `input`. All definitions must contain the following attributes:

#### Element links

<div>
  <tcf-attribs>
    <tcf-attrib name="type">
      <code>element</code>
    </tcf-attrib>
    <tcf-attrib name="label">
      The label of the link type displayed in the dropdown.
    </tcf-attrib>
    <tcf-attrib name="elementType">
      The fully qualified name of the element class.
    </tcf-attrib>
  </tcf-attribs>
</div>

#### Input links

<div>
  <tcf-attribs>
    <tcf-attrib name="type">
      <code>input</code>
    </tcf-attrib>
    <tcf-attrib name="label">
      The label of the link type displayed in the dropdown.
    </tcf-attrib>
    <tcf-attrib name="inputType">
      The html input type displayed to the user, e.g. <code>text</code>,
      <code>url</code> or <code>mail</code>.
    </tcf-attrib>
  </tcf-attribs>
</div>

::: tip
Defining the link types can be a tedious task. Remember that you can
define reusabe field definitions, see :doc:`../advanced/reusable-fields`.
:::

## Templating

You can access the url of the linked field by outputting it.

```twig
label: Link field demo
fields:
  linkField: link
---
<a href="{{ linkField }}">Read more</a>
```

You can use the `linkAttributes` helper to quickly retrieve
all anchor element attributes.

```twig
<a{{ linkField.linkAttributes }}>Read more</a>
```

The `linkAttributes` helper accepts additional attributes:

```twig
<a{{ linkField.linkAttributes({
  class: 'myLinkClass'
}) }}>Read more</a>
```

You can check for element links using `hasLinkedElement` and retrieve
linked elements using `linkedElement`:

```twig
{% if linkField.hasLinkedElement %}
  {{ linkField.linkedElement.title }}
{% endif %}
```
