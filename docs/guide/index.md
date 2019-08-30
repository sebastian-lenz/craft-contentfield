# Core concepts

## Schemas

Schemas are the core building blocks within the content field. A schema is
identified by a [qualifier](#qualifiers) and consists of multiple
[fields](#fields). The field ships with two built-in schema types:

- [Template schemas](./templates.md) are defined by a twig template.
- [Structure schemas](./schemas.md#structures) are defined by a yaml file.

## Qualifiers

A qualifier is the internal name of a schema. It consits of the schema type and
schema name separated by a colon like this:

```
{SCHEMA_TYPE}:{SCHEMA_NAME}
```

The schema type can be omitted. When no type is specified the content field tries
to find:

1. A local schema / structure with the given schema name.
2. A template schema with the given schema name.

### Qualifier matching

On multiple occasions qualifiers will be matched against a pattern, e.g.

- When specifying qualifiers as field attributes like the `schemas` attribute on
  the `instance` and `instances` fields.
- When using certain utility functions like `matchesQualifier` on schemas or
  `findInstances`, `hasNextSibling`, `hasParentInstance` or `hasPreviousSibling`
  on instances.

In all those instances you might specify your pattern in one of the following ways:

- As a complete, absolute qualifier with type and name:

  ```twig
  {% if instance.schema.matchesQualifier('template:path/to/template') %}
    ...
  {% endif %}
  ```

- A partial qualifier, will be resolved to a local or template schema:

  ```twig
  {% if instance.schema.matchesQualifier('path/to/template') %}
    ...
  {% endif %}
  ```

- A wildcard qualifier:

  ```twig
  {% if instance.schema.matchesQualifier('template:path/to/*') %}
    ...
  {% endif %}
  ```

- An array of patterns:
  ```twig
  {% if instance.schema.matchesQualifier([
    'template:path/to/template-a',
    'template:path/to/template-b',
    'template:path/other/*',
  ]) %}
    ...
  {% endif %}
  ```

## Fields

Fields define the properties a schema consists of, they are used to generate
the interface when editing instances in the control panel. For a complete list
of available fields types, see [fields](/fields/).

## Instances

A populated model that contains the actual values defiend by the fields of
a schema is called an instance. Instances are JSON documents that are stored
to your database.
