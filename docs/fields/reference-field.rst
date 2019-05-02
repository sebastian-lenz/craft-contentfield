***************
Reference field
***************

The reference field allows the editor to select other elements like
entries or assets.

.. code-block:: yaml

  simpleReference:
    type: reference
    label: My simple reference
    elementType: craft\elements\Asset

This field definition creates the following input in the control panel:

.. image:: images/reference-field-01.png
   :class: with-border

.. note::
   We provide several aliases of the reference field for asset and
   entry references, please see :ref:`fields-reference-aliases`.


Field attributes
================

.. include:: ../_includes/common-field-properties.rst

.. rubric::
   Location attributes

.. list-table::
   :widths: 30 70
   :header-rows: 1

   * - Property
     - Description

   * - criteria
     - Specifies additional filter criteria for the selectable elements.

   * - **elementType**
     - Required. The element class selected by the field, e.g.
       :code:`craft\elements\Asset`.

   * - limit
     - The maximum number of references allowed.

   * - sources
     - A list of sources the entry can be picked from.

   * - viewMode
     - The view mode the input should use in the control panel. Must
       be either :code:`large` or :code:`small`.


:code:`criteria`
----------------

Specifies additional filter criteria for the selectable elements. The
available filter criteria depend on the selected element type, we only
list the most commonly used criteria here.


.. rubric::
   Assets: :code:`kind`

Allows you to specify the asset kind the user is allowed to select.
Craft defines the following file kinds:

.. hlist::
   :columns: 6

   - access
   - audio
   - compressed
   - excel
   - flash
   - html
   - illustrator
   - image
   - javascript
   - json
   - pdf
   - photoshop
   - php
   - powerpoint
   - text
   - video
   - word
   - xml
   - unknown

.. code-block:: yaml

  criteria:
    kind:
    - image
    - video


:code:`elementType`
-------------------

The element class selected by the field. This can be any valid element
class, both from the core or from other plugins.

.. code-block:: yaml

  elementType: craft\elements\Asset


The Craft CMS defines the following element classes:

- craft\\elements\\Asset
- craft\\elements\\Category
- craft\\elements\\Entry
- craft\\elements\\GlobalSet
- craft\\elements\\Tag
- craft\\elements\\User


:code:`limit`
-------------

The maximum number of references allowed.

.. code-block:: yaml

  limit: 1


:code:`sources`
---------------

A list of sources the entry can be picked from. The available options depend
on the selected :code:`elementType`. For entry elements this usually controls
which sections are available, for assets it controls which folders are available.

.. code-block:: yaml

  sources:
  - section:560258d5-d8a0-4625-bcd2-11ed7ff1b225

.. note::
   The content field includes a utility page that lists all sources of the
   common entry types, in the control panel visit :code:`Utilities` >
   :code:`Content field utilities` > :code:`Sources`.


:code:`viewMode`
----------------

The view mode the input should use in the control panel. Must be either
:code:`large` or :code:`small`.

.. code-block:: yaml

  viewMode: small


Templating
==========

The reference field behaves like an array within the template, you can
iterate over the selected references and receive the elements.

.. code-block:: twig

  label: Reference field demo
  fields:
    referenceField:
      type: reference
      elementType: craft\elements\Asset
  ---
  <ul>
    {% for reference in referenceField %}
      <li>{{ reference.title }}</li>
    {% endfor %}
  </ul>

You can also access references based on their index:

.. code-block:: twig

  {% if referenceField|length > 0 %}
    {{ referenceField[0].title }}
  {% endif %}


:code:`first` / :code:`getFirst`
--------------------------------

The first helper allows you to quickly receive the first element.

.. code-block:: twig

  {% if referenceField.hasValue %}
    {{ referenceField.first.title }}
  {% endif %}


:code:`imageTag`
----------------

The image tag helper allows you to render an asset reference as an
image tag. To learn more about how image tags work, see
:doc:`../advanced/image-tags`.

.. code-block:: twig

  {{ referenceField.imageTag('image-config-name') }}




.. _fields-reference-aliases:

Aliases
=======

The reference field provides several aliases for commonly used field
configurations.


:code:`entry`
-------------

Allows the editor to pick one entry.

.. code-block:: yaml

  entryField:
    type: entry


:code:`entries`
---------------

Allows the editor to pick multiple entries.

.. code-block:: yaml

  entriesField:
    type: entries


:code:`file`
------------

Allows the editor to pick one file.

.. code-block:: yaml

  fileField:
    type: file


:code:`files`
-------------

Allows the editor to pick multiple files.

.. code-block:: yaml

  filesField:
    type: files


:code:`image`
-------------

Allows the editor to pick one image.

.. code-block:: yaml

  imageField:
    type: image


:code:`images`
--------------

Allows the editor to pick multiple images.

.. code-block:: yaml

  imagesField:
    type: images
