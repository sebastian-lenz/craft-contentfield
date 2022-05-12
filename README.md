# Content Field

The best way to work with templates in Craft. 

This field allows developers to define control panel fields directly 
within their templates. Templates can be nested and mixed as needed,
enabling complex content hierarchies to be built easily. And all this
comes with a big performance boost.


## Requirements

This plugin requires Craft CMS 4 or later.


## Installation

You can install this plugin from the Plugin Store or with Composer.

### From the Plugin Store
Go to the Plugin Store in your project’s Control Panel and search for 
“Content Field”. Then click on the “Install” button in its modal window.

### With Composer
Open your terminal and run the following commands:

```
# Go to the project directory
cd /path/to/my-project

# Tell Composer to load the plugin
composer require sebastianlenz/contentfield

# Tell Craft to install the plugin
./craft install/plugin contentfield
```


## Documentation

We have put together a documentation covers all aspects of this 
plugin. You can find the online version here:

https://sebastian-lenz.github.io/craft-contentfield/

### Examples

If you are more into reading through some working code we've created
a site that shows the functionality of this plugin through a series
of small examples:

https://github.com/sebastian-lenz/craft-contentfield-examples

### Showcase

Finally, if you would like to see what this plugin looks like in 
action there is a showcase that resembles a real world use case:

https://github.com/sebastian-lenz/craft-contentfield-showcase


## Caveats

Before using the Content Field, please carefully consider the 
following caveats:

- The field stores all data as a chunk of JSON data to your database.
  You cannot query, sort or filter the saved data in any way.
  
- When modelling your data structures, we use our own custom fields. 
  You cannot use other Craft fields within the Content Field.
  

## License

This plugin uses the Craft licence. If you are using this plugin in 
a commercial project, please consider licencing it.
