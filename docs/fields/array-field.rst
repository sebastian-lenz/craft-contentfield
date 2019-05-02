***********
Array field
***********

The array field allows editors to create a sequence of values. All members
of an array are of the same member field type defined by the :code:`member`
attribute. A simple array field definition looks like this:

.. code-block:: yaml

  simpleArray:
    type: array
    label: My simple array
    member:
      type: text

This field definition creates the following input in the control panel:

.. image:: images/array-field-01.png
   :class: with-border

.. note::
   The array field is most commonly used with a member of
   type :code:`instance`. We have a shortcut for specifying arrays
   of instances, see :doc:`instances-field`.

.. warning::
   You don't need an array field to store multiple references, the
   reference field is capable of holding multiple references,
   see :doc:`reference-field`.


Field attributes
================

.. include:: ../_includes/common-field-properties.rst

.. rubric::
   Array attributes

.. list-table::
   :widths: 30 70
   :header-rows: 1

   * - Property
     - Description

   * - **member**
     - Required. Declares the field each item in the array will use.
   * - collapsible
     - Displays the list items in the control panel as collapsible cards.
       This is turned on by default.


:code:`member`
--------------

Declares the field each item in the array will use, must be an object literal.

- You must at least specify the :code:`type` of the member field.
- You cannot specify a :code:`name` for array member fields.

.. code-block:: yaml

  member:
    type: text


:code:`collapsible`
-------------------

Displays the list items in the control panel as collapsible cards.
This is turned on by default.

.. code-block:: yaml

  collapsible: false


Templating
==========

The array value exposed to the twig template implements the default array
access methods, you can therefore loop through array values using the default
twig :code:`for` functionality.

.. code-block:: twig

  label: Array field demo
  fields:
    arrayField:
      type: array
      member:
        type: text
  ---
  <ul>
    {% for item in arrayField %}
      <li>{{ item }}</li>
    {% endfor %}
  </ul>

You can also directly access individual items and check the length of the array.

.. code-block:: twig

  {% if arrayField|length > 0 %}
    <li>{{ arrayField[0] }}</li>
  {% endif %}
