---
sidebarDepth: 2
attributes:
  - name: ckeConfig
    description: >
      The CKEditor config to use, either the name of a config file within
      :code:`config/content/cke` or an inline config.
  - name: editorClass
    description: A css class added to the editor container.
  - name: enableSourceEditingForNonAdmins
    description: Whether non-admins may use source editing. Defaults to false.
  - name: searchable
    description: Whether the contents are added to the search index. Defaults to true.
  - name: showWordCount
    description: Whether to show the word count below the editor. Defaults to false.
  - name: translatable
    description: >
      Defines whether the text field will be translated when synchronizing
      content fields across sites. Defaults to true.
  - name: wordLimit
    description: The maximum number of words allowed.
---

# CKEditor field

The CKEditor field allows the editor to enter rich text formatted using
the CKEditor plugin provided by Craft CMS.

```yaml
myCKEditorField:
  type: ckeditor
  ckeConfig: default
```

::: warning
You must install the CKEditor plugin (`craftcms/ckeditor` 5.10 or later) in
order to use this field type.
:::

## Attributes

<tcf-field-attribs :attributes="$page.frontmatter.attributes" />

### `ckeConfig`

The name of a CKEditor config stored within `config/content/cke`. The file
name, without extension and relative to that directory, is the name of the
config: `config/content/cke/default.yml` defines the config `default`.

A config may contain any setting of a native CKEditor field, most notably:

```yaml
# config/content/cke/default.yml
toolbar:
  - heading
  - '|'
  - bold
  - italic
  - link
headingLevels: [2, 3]
advancedLinkFields: []
options:
  bodyClass: myEditor
css: null
```

Alternatively, all configs can be stored in a single file `config/content/cke.yml`
using the config names as top level keys, or the config can be given inline:

```yaml
ckeConfig:
  toolbar: [bold, italic, link]
  headingLevels: false
```

## Templating

Printing the CKEditor field will return html contents of the field:

```twig
label: CKEditor field demo
fields:
  ckeditorField:
    type: ckeditor
---
{{ ckeditorField }}
```

## Upgrading from craftcms/ckeditor 4

Prior to craftcms/ckeditor 5, CKEditor configs were stored in the project config
and `ckeConfig` referenced them by their uid. craftcms/ckeditor 5 removes these
configs, so Content Field now reads them from `config/content/cke`.

1. Update Content Field and `craftcms/ckeditor` (`^5.10.0`) together and run
   the pending migrations, e.g. with `php craft migrate/all`, `php craft up` or
   the "Finish up" button in the control panel. When the CKEditor migration
   removes the old configs, Content Field exports each of them to
   `config/content/cke/<config-name>.yml`, no matter how the migrations run. The
   exported files contain the original `uid`, so legacy references keep working
   but log a deprecation warning.
2. Run `php craft contentfield/cke/check --fix` to replace all uid references
   in `config/content` and the templates with the config names. Without `--fix`
   the command only reports problems and exits with an error, which makes it
   suitable for CI.
3. Optionally rename the exported files and update the references accordingly.
4. Commit the new files in `config/content/cke` together with the changes to
   the project config.

If the configs were removed without being exported (e.g. the project was
upgraded with an older Content Field release), restore the old project config
files from git and export them from there:

```bash
git archive <old-revision> config/project/ckeditor | tar -x -C /tmp/old
php craft contentfield/cke/export --path=/tmp/old/config/project/ckeditor/configs
```
