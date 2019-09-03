# Create an entry template

In the next steps we'll create a new section inside the Craft CMS and add
a content field named `pageContent` to the entry type of that section.

Each section type in Craft is tied to a template that will render entries inside
that section. So lets start by creating that basic entry template. Create a new
file named `tutorial-section.twig` in your `templates` directory and paste the
following code into it.

**templates/tutorial-section.twig**

```twig
<html>
<head>
  <title>{{ entry.title }}</title>
</head>
<body>

{% display entry.pageContent %}

</body>
</html>
```

This is a very basic html template that will output the markup of your content
field to the page. Note the special `display` tag used to render the field
`pageContent`. It's a twig token installed by the content field and it is
used to render elements of the content field quickly.
