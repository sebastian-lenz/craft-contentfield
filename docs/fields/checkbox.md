---
sidebarDepth: 2
attributes:
  - name: defaultValue
    description: Defines the initial value of the checkbox.
---

# Checkbox field

Allows the editor to set a flag using a checkbox.

```yaml
simpleCheckbox:
  type: checkbox
  label: My simple checkbox
```

This field definition creates the following input in the control panel:

![A chceckbox field in the control panel](./images/checkbox-field-01.png)

## Attributes

<tcf-field-attribs :attributes="$page.frontmatter.attributes" />

### `defaultValue`

Defines the initial value of the checkbox.

```yaml
defaultValue: true
```

## Templating

Printing the checkbox field returns the string :code:`true` or :code:`false`.

```twig
label: Checkbox field demo
fields:
  checkboxField:
    type: checkbox
---
{{ checkboxField }}
```

### hasValue

Use the default :code:`hasValue` method to retrieve the boolean value
of the checkbox.

```twig
{% if checkboxField.hasValue %}
  ...
{% endif %}
```
