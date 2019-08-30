---
sidebarDepth: 2
attributes:
  - name: disableAlpha
    description: Hides the alpha setting in the color popup. This is turned on by default.
  - name: presetColors
    description: Allows you to specify multiple predefined color values.
---

# Color field

The color field allows editors to freely select a color.

```yaml
myColorField:
  type: color
```

This field definition creates the following input in the control panel:

![A color field in the control panel](./images/color-field-01.png)

::: tip
If you want the editor only to be able to pick from a fixed
set of colors, see [swatch color field](swatch-color.md).
:::

## Attributes

<tcf-field-attribs :attributes="$page.frontmatter.attributes" />

### `disableAlpha`

Hides the alpha setting in the color popup. This is turned on by default.

```yaml
disableAlpha: false
```

### `presetColors`

Allows you to specify multiple predefined color values. Must be a list
of hex color values.

```yaml
presetColors:
  - '#ff0000'
  - '#00ff00'
  - '#0000ff'
```

::: warning
You must quote hex color values in YAML.
:::

## Templating

You can print a color field in twig to output its css color representation.

```twig
label: Color field demo
fields:
  colorField:
    type: color
---
<div style="background:{{ colorField }};"></div>
```
