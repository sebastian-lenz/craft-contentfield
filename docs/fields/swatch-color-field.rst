******************
Swatch color field
******************

The swatch color field is a special select field that allows the editor
to choose a color from a set of predefined colors.

.. code-block:: yaml

  simpleSwatchColor:
    type: swatchcolor
    label: My simple swatch color
    options:
      red: "#f00"
      green: "#0f0"
      blue: "#00f"

This field definition creates the following input in the control panel:

.. image:: images/swatch-color-field-01.png
   :class: with-border

.. note::
   If you want the editor to be able to freely pick any color, see :doc:`color-field`.


Field attributes
================

.. include:: ../_includes/common-field-properties.rst

.. rubric::
   Select attributes

.. list-table::
   :widths: 30 70
   :header-rows: 1

   * - Property
     - Description

   * - defaultValue
     - The key of the preselected value.

   * - options
     - Defines the available static options.

   * - enumeration
     - The qualifier of an enumeration class that defines the available
       options. Used to programmatically declare options.

.. note::
   The swatch color field is a select field under the hood and therefore behaves
   identical to a select field. The only difference is that the :code:`label` of
   each option must be a valid css color.
