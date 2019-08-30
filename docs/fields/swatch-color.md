---
sidebarDepth: 2
attributes:
  - name: defaultValue
    description: >
      The key of the preselected value.
  - name: options
    description: >
      Defines the available static options.
  - name: enumeration
    description: >
      The qualifier of an enumeration class that defines the available
      options. Used to programmatically declare options.
---

# Swatch color field

The swatch color field is a special select field that allows the editor
to choose a color from a set of predefined colors.

```yaml
mySwatchColorField:
  type: swatchcolor
  options:
    red: '#f00'
    green: '#0f0'
    blue: '#00f'
```

This field definition creates the following input in the control panel:

![A swatch color field in the control panel](./images/swatch-color-field-01.png)

::: tip
If you want the editor to be able to freely pick any color, see :doc:`color-field`.
:::

## Attributes

<tcf-field-attribs :attributes="$page.frontmatter.attributes" />

::: tip
The swatch color field is a select field under the hood and therefore behaves
identical to a select field. The only difference is that the :code:`label` of
each option must be a valid css color.
:::
