---
sidebarDepth: 2
attributes:
  - name: constants
    path: /guide/templates
  - name: fields
    path: /guide/templates
  - name: grid
    path: /guide/templates
  - name: icon
    path: /guide/templates
  - name: label
    path: /guide/templates
  - name: model
    path: /guide/templates
  - name: preview
    path: /guide/templates
  - name: previewImage
    path: /guide/templates
  - name: previewLabel
    path: /guide/templates
  - name: style
    path: /guide/templates
---

# Structure schemas

A structure is a schema defined by configuration files. It shares most attributes and
behaviors of a template schema, the primary difference is that it cannot be rendered
directly.

Structures can be defined [globally](structures.html#global-structures) in a
shared configuration file or [locally](structures.html#local-structures) inside
template schemas.

## Attributes

<tcf-field-attribs />

## Global structures

Global structure can be defined in the configuration file `config/content/structures.yml`.
The configuration keys at the top level of the file define the structure names. Beneath
each key a schema configuration must be placed.

**config/content/structures.yml**

```yaml
acmeSlide:
  label: Slide
  fields:
    image: image
    title: text

acmeAddress:
  label: Address
  fields:
  ...
```

The qualifier of a global structure looks like this:

```
structure:{STRUCTURE}
```

The complete qualifier for the schema defined in the example would be  
`structure:acmeSlide`. This qualifier can be used to reference this
schema in templates, e.g.:

**templates/slideshow.twig**

```twig{5}
label: Global structures example
fields:
  slides:
    type: instances
    schemas: structure:acmeSlide
---
<ul>
  {% for slide in slides %}
    <li>
      {{ slide.image.imageTag() }}
      <p>{{ slide.title }}</p>
    </li>
  {% endfor %}
</ul>
```

## Local structures

Local structures can be defined in template schemas using the `structures` attribute.
A structure defined locally can be referenced by its name soley.

**templates/local-structures.twig**

```twig{2-7,11}
label: Local structures example
structures:
  acmeSlide:
    label: Slide
    fields:
      image: image
      title: text
fields:
  slides:
    type: instances
    schemas: acmeSlide
---
<ul>
  {% for slide in slides %}
    <li>
      {{ slide.image.imageTag() }}
      <p>{{ slide.title }}</p>
    </li>
  {% endfor %}
</ul>
```

The qualifier of a local structure looks like this:

```
structure:{STRUCTURE}@{CONTAINER}
```

The complete qualifier for the schema defined in the example would be  
`structure:acmeSlide@template:local-structures`.
