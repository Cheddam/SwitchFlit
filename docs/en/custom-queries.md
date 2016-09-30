# Custom Queries

As of SwitchFlit 1.0 Beta 1, the `SwitchFlit\WithCustomQuery` interface is available, which allows you to add filters and other modifications to the DataList of records before it is parsed and sent to the browser. To get started, simply add the interface to your SwitchFlitable DataObject, along with the now required `SwitchFlitQuery()` method:

```php
<?php

use SwitchFlit\SwitchFlitable;
use SwitchFlit\WithCustomQuery;

class MyDataObject extends DataObject implements SwitchFlitable, WithCustomQuery
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
    
    public static function SwitchFlitQuery(\DataList $data)
    {
        return $data->filter(['Name:StartsWith' => 'G']);
    }
}
```

As you can see, `SwitchFlitQuery()` is passed a `DataList` containing the entire `MyDataObject` record list, and you can now make any modifications you like via `DataList`'s API. Ensure that you return the final state of the `DataList` so that it can be utilised by SwitchFlit.
