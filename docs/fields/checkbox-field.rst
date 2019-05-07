**************
Checkbox field
**************

Allows the editor to set a flag using a checkbox.

.. code-block:: yaml

   simpleCheckbox:
     type: checkbox
     label: My simple checkbox

This field definition creates the following input in the control panel:

.. image:: images/checkbox-field-01.png
   :class: with-border


Field attributes
================

.. include:: ../_includes/common-field-properties.rst

.. rubric::
   Checkbox attributes

.. list-table::
   :widths: 30 70
   :header-rows: 1

   * - Property
     - Description

   * - defaultValue
     - Defines the initial value of the checkbox.


:code:`defaultValue`
--------------------

Defines the initial value of the checkbox.

.. code-block:: yaml

  defaultValue: true


Templating
==========

Printing the checkbox field returns the string :code:`true` or :code:`false`.

.. code-block:: twig

  label: Checkbox field demo
  fields:
    checkboxField:
      type: checkbox
  ---
  {{ checkboxField }}


:code:`hasValue`
----------------

Use the default :code:`hasValue` method to retrieve the boolean value
of the checkbox.

.. code-block:: twig

   {% if checkboxField.hasValue %}
     ...
   {% endif %}
