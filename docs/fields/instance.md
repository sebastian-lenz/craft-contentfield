---
sidebarDepth: 2
attributes:
  - name: schemas
    required: true
    description: >
      A list of all allowed schemas. If multiple schemas are
      specified, a dropdown will be shown in the control panel.
---

# Instance field

The instance field allows a field to hold another template (or schema)
allowing you to build nested hierarchies.

```yaml
simpleInstance:
  type: instance
  label: My simple instance
  schemas:
    - path/to/template-a.twig
    - path/to/template-b.twig
```

This field definition creates the following input in the control panel:

![An instance field in the control panel](./images/instance-field-01.png)

## Attributes

<tcf-field-attribs :page="$page" />

### `schemas`

A list of all allowed schemas. If multiple schemas are specified, a dropdown
will be shown in the control panel. This can either be a single string or a list
of schema names.

```yaml
schemas:
  - path/to/template-a.twig
  - path/to/template-b.twig
```

You may use wildcards to include entire directories.

```yaml
schemas: path/to/*
```

## Templating

You can render the template of the instance field by using the :code:`display`
twig tag.

```twig
label: Instance field demo
fields:
  instanceField:
    type: instance
    schemas: blocks/\*
---
{% display instanceField %}
```

You can also use the `html` utility function to retrieve the rendered
template as a twig html node.

```twig
{{ instanceField.html }}
```

The `html` utility function allows you to pass additional template
variables:

```twig
{{ instanceField.html({
  extraValue: 'Some value'
}) }}
```

The instance contains the full data set of the schema and you can directly
access fields defined on the schema:

```twig
{{ instanceField.title }}
```
