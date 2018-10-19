# Fields

The content field comes with a separate field system, which unfortunately 
means you cannot use the default fields of Craft with it. But, heads up, we've
included all the fields you probably need when building UIs for your templates.

The field system differentiates between the field type and the widget type. The 
field types defines the raw data stored in the background and handles validation,
the widget types decides which visual input will be presented to the user.

## Basic fields

### Enumeration field

### Number field

### Reference field

References allow you to store a connection to another Craft element, e.g. to another
entry or to an asset. They internally store an array of numbers which resemble the
ids of the linked elements.

#### Reference widget

The reference widget displays the default Craft UI for selecting references.

### Text field

Text fields store a simple string value.

#### Input widget

Displays a generic single line input field.

#### Redactor widget

Displays a Redactor instance for entering formatted text. This widget uses the
Redactor instance exposed by the official Redactor plugin, you must install it
to use this field.

#### Textarea widget

Displays a generic multi line input field.


## Advanced fields

### Array field

### Instance field


