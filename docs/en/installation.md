# Installation

SwitchFlit is a cinch to get started with. First off, ensure you have pulled in the module via Composer:

`$ composer require cheddam/silverstripe-switchflit`

Next, you'll want to apply the `SwitchFlitable` interface to the DataObject(s) you intend to expose via the Quick-Switcher UI. This interface requires the implementation of two functions:

- `SwitchFlitTitle()` should return the title of this DataObject, to be searched and displayed in the UI.
- `SwitchFlitLink()` should return a unique URL that this DataObject can be accessed at, i.e. `/someroute/{ID}` - see the example below.

```php
<?php

use SwitchFlit\SwitchFlitable;

class MyDataObject extends DataObject implements SwitchFlitable
{
    private static $db = [
        'Name' => 'Varchar(100)',
    ];
    
    public function SwitchFlitTitle()
    {
        return $this->Name;
    }
    
    public function SwitchFlitLink()
    {
        return '/mydataobjects/' . $this->ID;
    }
}
```
    
Finally, you'll need to include the SwitchFlit UI in your template. This generally fits best in the bottom of your top level template, and will look something along these lines:

```html
    ...
    <% include SwitchFlit DataObject="MyDataObject" %>
```

You'll see that it takes the name of the DataObject you have made SwitchFlitable. You can also specify an alias, in case the name of your DataObject isn't user friendly:

```html
    ...
    <% include SwitchFlit DataObject="WeirdlyNamedDataObject" Alias="NiceName" %>
```

You should now be able to visit your page and invoke the UI with Cmd + K on macOS & iOS, or CTRL + K on Windows & Linux.

# Configuration

## Key combination

This can be changed using the [SilverStripe Configuration API](https://docs.silverstripe.org/en/3.4/developer_guides/configuration/configuration/)::

```yaml
'SwitchFlit\SwitchFlitController':
  key_combo: 'ctrl + 80'
  key_combo_mac: 'meta + 80'
```

You can use `alt`, `ctrl`, `meta`, `shift` and any [numeric keycode](http://keycode.info/).

## Further reading

If you're interested in filtering the record list sent to the browser, check out [Custom Queries](custom-queries.md).

If you'd like to change the design to suit your particular project, take a look at [Changing Design](changing-design.md).
