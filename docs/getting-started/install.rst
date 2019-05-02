************
Installation
************

1. **Download the plugin**

   You can either download the content field using the Craft plugin
   store or by using composer.

   - **Craft plugin store**

     Open the control panel of your site, open the section
     :code:`Plugin Store` and search for "Content field". On the detail
     page of the plugin, find and click the button :code:`Install`.

   - **Composer**

     Open a terminal and navigate to the root directory of your Craft
     installation. Using composer you can install the plugin by typing:

     .. code-block:: shell

       $ composer require sebastianlenz/contentfield

2. **Optional: Download the Redactor plugin**

   The content field offers a tight integration of the official Redactor
   plugin. If you want to take advantage of that field type, install
   the Redactor plugin from the plugin store by running:

   .. code-block:: shell

     $ composer require craftcms/redactor

3. **Install the pugin**

   After you have downloaded the plugin, open the control panel of
   your site, open the section :code:`Settings` and navigate to the
   :code:`Plugins` page. Install the plugin by clicking on the gear
   icon next to the content field plugin and select :code:`Install`.

   **Optional** Do the same with the Redactor plugin.

   .. image:: images/install-01-plugins.png
      :class: with-border

