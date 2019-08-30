# Create block templates

Head back to your templates directory and create a new directory named
`blocks`. Inside that directory, create a new file called
`text.twig` and paste the following code.

**templates/blocks/text.twig**

```twig
label: Text block
icon: material:format_align_left
preview: >
  {{ body.snippet }}
fields:
  body:
    type: redactor
---
<div class="container">
  {{ body.html }}
</div>
```

There are two new attributes in the Yaml block:

- The `icon` attribute defines an icon for the template type in order to
  make blocks easier to distinguish in the control panel. A list of
  all available icons can be found in the control panel
  `Utilities` > `Content field utilities`.

- The `preview` attribute contains a simple preview of the block that
  will be shown to the editor in the control panel. It's a handlebars template
  that has access to all fields defined in the current template.

::: tip
You can learn more about handlebars templates on their official site:
[handlebarsjs.com](https://handlebarsjs.com/)
:::

Next create a new file called `image.twig` in the same directory
and paste the following code.

**templates/blocks/image.twig**

```twig
label: Image block
icon: material:picture
preview: >
  {{ image }}
fields:
  image:
    type: image
    rules: required
---
<div class="container">
  <img src="{{ image.first.url }}" />
</div>
```

The image field type is a field that allows editors to select assets. Note
the `rule` attribute on the image field, it marks the field as being
required.
