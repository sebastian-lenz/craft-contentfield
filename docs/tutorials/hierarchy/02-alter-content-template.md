# Add the blocks to the content template

We'll now add those two block templates as a flexible list of entries
to our root template. Open the template of our content field
`templates/page-content.twig` and make the following changes.

**templates/page-content.twig**

```twig{7-9,20}
label: Page content template
fields:
  title:
    type: text
  body:
    type: redactor
  blocks:
    type: instances
    schemas: blocks/*
---
<div class="container">
  {% if title.hasValue %}
    <h1>{{ title }}</h1>
  {% endif %}

  {{ body.html }}

</div>

{% display blocks %}
```

This defines a new field called `blocks` of the type `instances`.
An instance field is a field that can hold other templates. The attribute
`schemas` specifies which other templates are allowed here. As you can
see one may use wildcards to allow entire directories of templates to be included.
