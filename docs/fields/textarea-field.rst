**************
Textarea field
**************

The textarea field allows the editor to enter multiple lines of text.

.. code-block:: yaml

  simpleTextarea:
    type: textarea
    label: My simple textarea

This field definition creates the following input in the control panel:

.. image:: images/textarea-field-01.png
   :class: with-border


Field attributes
================

.. include:: ../_includes/common-field-properties.rst

.. rubric::
   Textarea attributes

.. list-table::
   :widths: 30 70
   :header-rows: 1

   * - Property
     - Description

   * - translatable
     - Defines whether the text field will be translated when synchronizing
       content fields across sites. Defaults to false.


:code:`translatable`
--------------------

Defines whether the text field will be translated when synchronizing
content fields across sites. Defaults to false.

.. code-block:: yaml

  translatable: true


Templating
==========

Printing the textarea field returns the textual contents of the field.

.. code-block:: twig

  label: Textarea field demo
  fields:
    textareaField:
      type: textarea
  ---
  <p>{{ textareaField }}</p>


:code:`html`
------------

Returns the contents of the textarea field as a twig html node.

.. code-block:: twig

  <p>{{ textareaField.html }}</p>
