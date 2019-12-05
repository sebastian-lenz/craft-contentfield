---
sidebarDepth: 2
---

# Fields

Fields are the building blocks of schemas within the content field. Fields
are defined within the `fields` attribute on [template](./templates.html)
and [structure](./structures.html) schemas.

All fields can be customized, this page describes all common field attributes.
For attributes specific to individual field types please see
[field types](/fields/).

## Attributes

### `group`

The group attribute allows you to group fields together. All following
fields will be put into a group until another group attribute occurs.
You can simply specify the label of the group:

```yaml
label: Group demo
fields:
  fieldA:
    type: text
    group: My group title
  fieldB:
    type: text
```

Which creates the following field group in the control panel:

![A group of fields](./images/common-group-01.png)

You can also pass an option object to set multiple css properties
of the field group. Combined with the ability to specify grid layouts
on the schema (see [`grid`](templates.html#grid) ), you can build complex layouts.

```yaml
label: Group demo
grid: >
  "left right" / 3fr 2fr
fields:
  fieldA:
    type: text
    group:
      label: My left group title
      gridArea: left
  fieldB:
    type: textarea
  fieldC:
    type: textarea
    group:
      label: My right group title
      gridArea: right
```

Which creates the following layout in the control panel:

![Multiple field groups using a css grid layout](./images/common-group-02.png)

The following css attributes are supported:

`alignSelf`,
`gridArea`,
`gridColumn`,
`gridColumnEnd`,
`gridColumnStart`,
`gridRow`,
`gridRowEnd`,
`gridRowStart`,
`justifySelf`,
`placeSelf`.

### `instructions`

Additional instructions for the field in the control panel. Will be shown
beneath the field label.

```yaml
instructions: Additional instructions for this field.
```

### `label`

The primary label of the input field in the control panel. When omitted, a
label will be generated from the name of the field.

```yaml
label: My custom label
```

### `rules`

Defines the validation rules of the field. The content field uses the
validation mechanics of the Yii framework and you can use most of the
provided validators with the content field.

If you only need one validator and the validator does not require any
options, you may pass the name of the validator.

```yaml
rules: required
```

Otherwise you may supply a list of validators. The name of the validator
must be given by the `type` option. The following notation has the
same result as the previous example.

```yaml
rules:
  - type: required
```

This way you can set additional options on each validator:

```yaml
rules:
  - type: required
  - type: email
    checkMX: true
```

::: tip
A list of all validators can be found here:
[yiiframework.com](https://www.yiiframework.com/wiki/56/reference-model-rules-validation)
:::

### `style`

Sets custom css style attributes on the field itself. When given directly, the sttributes
apply to the medium breakpoint, e.g.:

```yaml{4-5}
fields:
  myStyledField:
    type: text
    style:
      width: 100px
```

Is equivalent to the following example.

```yaml{4-6}
fields:
  myStyledField:
    type: text
    style:
      medium:
        width: 100px
```

The following style attributes are suported:
`alignSelf`,
`flex`,
`flexBasis`,
`flexGrow`,
`flexShrink`,
`justifySelf`,
`width`.

The breakpoints `small`, `medium` and `large` are supported.

### `width`

Defines the width of the field within the control panel. Allows you to stack fields
horizontally. Can be any valid css width value, can also be given as a fraction, e.g. `6/12`.
This is a shortcut for the width style attribute at the medium breakpoint.

```yaml
label: Width demo
fields:
  fieldA:
    type: text
    width: 4/12
  fieldB:
    type: text
    width: 8/12
```

Which creates the following layout in the control panel:

![Multiple field groups using the width attribute](./images/common-width-01.png)

## Global fields

Fields can be defined globally in the configuration file `config/content/fields.yml`.
The configuration keys at the top level of the file define the field names. Beneath
each key a field configuration must be placed.

**config/content/fields.yml**

```yaml
acmeSwatchColor:
  type: swatchColor
  options:
    red: '#D63545'
    green: '#28a745'
    blue: '#007bff'

acmeColumnSizes:
  type: select
  ...
```

Fields defiend like this can be referenced in schemas by specifying the their
name as the type of a field.

**templates/section.twig**

```twig{4}
label: Section
fields:
  myTheme:
    type: acmeSwatchColor
---
<div class="{{ myTheme }}">
  ...
</div>
```
