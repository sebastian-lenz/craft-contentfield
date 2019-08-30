---
sidebarDepth: 2
attributes:
  - name: defaultValue
    description: Defines the initial value of the lightswitch.
---

# Light switch field

Allows the editor to set a flag using a light switch.

```yaml
simpleLightswitch:
  type: lightswitch
  label: My simple light switch
```

This field definition creates the following input in the control panel:

![A lightswitch field in the control panel](./images/lightswitch-field-01.png)

## Attributes

<tcf-field-attribs :attributes="$page.frontmatter.attributes" />

## `defaultValue`

Defines the initial value of the light switch.

```yaml
defaultValue: true
```

# Templating

Printing the light switch field returns the string :code:`true` or :code:`false`.

```twig
label: Light switch field demo
fields:
lightswitchField:
type: lightswitch
---
{{ lightswitchField }}
```
