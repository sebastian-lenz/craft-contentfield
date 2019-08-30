# Create a content template

When using the content field, everything starts with a template. Templates
that should be used inside the content field must contain some additional
meta data in the form of a Yaml preamble. Yaml is a simple language that allows
us to write down structured data.

::: tip
A quick guide to understand Yaml can be found here:
[github.com/planetjekyll](https://github.com/planetjekyll/quickrefs/blob/master/YAML.md)
:::

We will now create the root template of our content field. Create a new file
named `page-content.twig` in your `templates` directory and paste
the following code into it.

**templates/page-content.twig**

```twig
label: Page content template
fields:
  title:
    type: text
  body:
    type: redactor
---
<div class="container">
  {% if title.hasValue %}
    <h1>{{ title }}</h1>
  {% endif %}

  {{ body.html }}
</div>
```

Notice the yaml configuration above the twig template, all templates used by
the content field must contain a section like this.

- The only required setting is the `label`, it contains the
  human readable name of the template.

- Most of the time you'll want to define one or more `fields`. The
  content field will parse those fields and generate a form in the control
  panel for editors to fill out. Most of the fields only require one mandatory
  option, the field `type`. As you can see, inside the twig template
  you can access the fields and output them.
