******************
Light switch field
******************

Allows the editor to set a flag using a light switch.

.. code-block:: yaml

   simpleLightswitch:
     type: lightswitch
     label: My simple light switch

This field definition creates the following input in the control panel:

.. image:: images/lightswitch-field-01.png
   :class: with-border


Field attributes
================

.. include:: ../_includes/common-field-properties.rst

.. rubric::
   Light switch attributes

.. list-table::
   :widths: 30 70
   :header-rows: 1

   * - Property
     - Description

   * - defaultValue
     - Defines the initial value of the checkbox.


:code:`defaultValue`
--------------------

Defines the initial value of the light switch.

.. code-block:: yaml

  defaultValue: true


Templating
==========

Printing the light switch field returns the string :code:`true` or :code:`false`.

.. code-block:: twig

  label: Light switch field demo
  fields:
    lightswitchField:
      type: lightswitch
  ---
  {{ lightswitchField }}


:code:`hasValue`
----------------

Use the default :code:`hasValue` method to retrieve the boolean value
of the light switch.

.. code-block:: twig

   {% if lightswitchField.hasValue %}
     ...
   {% endif %}
