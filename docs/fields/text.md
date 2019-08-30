---
sidebarDepth: 2
attributes:
  - name: translatable
    description: >
      Defines whether the text field will be translated when synchronizing
      content fields across sites. Defaults to false.
---

# Text field

The text field allows the editor to enter a single line of text.

```yaml
myTextField:
  type: text
```

This field definition creates the following input in the control panel:

![A text field in the control panel](./images/text-field-01.png)

## Attributes

<tcf-field-attribs :attributes="$page.frontmatter.attributes" />

### `translatable`

Defines whether the text field will be translated when synchronizing
content fields across sites. Defaults to false.

```yaml
translatable: true
```

## Templating

Printing the text field returns the textual contents of the field.

```twig
label: Text field demo
fields:
  textField:
    type: text
---
<h1>{{ textField }}</h1>
```

## `html`

Returns the contents of the text field as a twig html node.

```twig
<h1>{{ textField.html }}</h1>
```
