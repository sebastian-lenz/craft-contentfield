**********
Link field
**********

The link field allows editors to create a link to another element or an
external url.

.. code-block:: yaml

  simpleLinkField:
    type: link
    label: My simple link

This field definition creates the following input in the control panel:

.. image:: images/link-field-01.png
   :class: with-border


Field attributes
================

.. include:: ../_includes/common-field-properties.rst

.. rubric::
   Link attributes

.. list-table::
   :widths: 30 70
   :header-rows: 1

   * - Property
     - Description

   * - allowNewWindow
     - Whether the option top open links in new a new window should
       be shown. Defaults to true.
   * - linkTypes
     - Defines the available link types. By default this contains definitions
       for url, mail, entry and asset links.


:code:`allowNewWindow`
----------------------

Whether the option top open links in new a new window should be shown.
Defaults to true.

.. code-block:: yaml

  allowNewWindow: false


:code:`linkTypes`
-----------------

Defines the available link types. By default this contains definitions
for url, mail, entry and asset links. This value must be an object,
the keys define the internal link names and the values must contain the
link definitions.

.. code-block:: yaml

  linkTypes:
    url:
      type: input
      inputType: url
      label: Url
    entry:
      type: element
      elementType: craft\elements\Entry
      label: Entry

There are two types of supported link input methods: :code:`element`
and :code:`input`. All definitions must contain the following attributes:

.. list-table::
   :widths: 30 70
   :header-rows: 1

   * - Property
     - Description

   * - type
     - The link type, must be either :code:`element` or :code:`input`.
   * - label
     - The label of the link type displayed in the dropdown.

.. rubric::
   Element links

.. list-table::
   :widths: 30 70
   :header-rows: 1

   * - Property
     - Description

   * - elementType
     - The fully qualified name of the element class.
   * - sources
     - A list of allowed element sources.

.. rubric::
   Input links

.. list-table::
   :widths: 30 70
   :header-rows: 1

   * - Property
     - Description

   * - inputType
     - The html input type displayed to the user, e.g. :code:`text`,
       :code:`url` or :code:`mail`.

.. note::
   Defining the link types can be a tedious task. Remember that you can
   define reusabe field definitions, see :doc:`../advanced/reusable-fields`.


Templating
==========

You can access the url of the linked field by outputting it.

.. code-block:: twig

  label: Link field demo
  fields:
    linkField:
      type: link
  ---
  <a href="{{ linkField }}">Read more</a>

You can use the :code:`linkAttributes` helper to quickly retrieve
all anchor element attributes.

.. code-block:: twig

  <a{{ linkField.linkAttributes }}>Read more</a>

The :code:`linkAttributes` helper accepts additional attributes:

.. code-block:: twig

  <a{{ linkField.linkAttributes({
    class: 'myLinkClass'
  }) }}>Read more</a>

You can check for element links using :code:`hasLinkedElement` and retrieve
linked elements using :code:`linkedElement`:

.. code-block:: twig

  {% if linkField.hasLinkedElement %}
    {{ linkField.linkedElement.title }}
  {% endif %}
