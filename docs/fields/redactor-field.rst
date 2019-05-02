**************
Redactor field
**************

The redactor field allows the editor to enter rich text formatted using
the Redactor plugin provided by Craft CMS.

.. code-block:: yaml

  simpleRedactor:
    type: redactor
    label: My simple Redactor

This field definition creates the following input in the control panel:

.. image:: images/redactor-field-01.png
   :class: with-border

.. warning::
   You must install the Craft Redactor plugin from the plugin store in
   order to use this field type.


Field attributes
================

.. include:: ../_includes/common-field-properties.rst

.. rubric::
   Redactor attributes

.. list-table::
   :widths: 30 70
   :header-rows: 1

   * - Property
     - Description

   * - purifierConfig
     - Allows you to configure the html purifier.

   * - redactorConfig
     - Specifies the redactor config to use. Defaults to :code:`Standard.json`.

   * - translatable
     - Defines whether the text field will be translated when synchronizing
       content fields across sites. Defaults to false.


:code:`purifierConfig`
----------------------

Allows you to configure the html purifier. A list of all available purifier options
can be found here: http://htmlpurifier.org/live/configdoc/plain.html

.. code-block:: yaml

  purifierConfig:
    Attr.EnableID: true
    Attr.AllowedFrameTargets:
    - _blank
    HTML.AllowedComments:
    - pagebreak


:code:`redactorConfig`
----------------------

Specifies the redactor config to use. Defaults to :code:`Standard.json`.

.. code-block:: yaml

  redactorConfig: Simple.json


:code:`translatable`
--------------------

Defines whether the text field will be translated when synchronizing
content fields across sites. Defaults to false.

.. code-block:: yaml

  translatable: true


Templating
==========

Printing the redactor field will return html contents of the field. Remember
to apply the raw filter when doing this:

.. code-block:: twig

  label: Redactor field demo
  fields:
    redactorField:
      type: redactor
  ---
  {{ redactorField|raw }}


:code:`html`
----------------------------------

Returns the html contents as a twig html node.

.. code-block:: twig

  {{ redactorField.html }}
