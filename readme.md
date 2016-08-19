# SwitchFlit

__NOTE: This module is under active development - set your expectations accordingly!__

A plug-and-play quick-switch UI for SilverStripe DataObjects.

## Premise

Quick-Switcher UIs are super useful for power users, and available today in a variety of applications and forms, such as Slack, Sublime Text, and Spotlight. With SwitchFlit, you can specify a DataObject's Name and Link fields and immediately enable a basic Quick-Switcher in your web app.

## Installation / Configuration

`composer require cheddam/silverstripe-switchflit`

SwitchFlit works with any DataObject that can provide a Title and a URL to access it. This includes SiteTree descendants, which we will use as an example below.

Simply implement the `SwitchFlitable` interface as follows:

```php
class Page extends SiteTree implements SwitchFlit\SwitchFlitable
{
	public function SwitchFlitTitle()
	{
		return $this->Title;
	}

	public function SwitchFlitLink()
	{
		return $this->Link();
	}
}
```

Now add the SwitchFlit template to (the end of) your layout, specifying the model you configured:

```html
...
    <p>Other content</p>
</div>

<% include SwitchFlit Model="Page" %>
```

You should now be able to invoke the Switcher with Command + K on macOS, or CTRL + K on Windows.
Pressing Enter will send you to the first result in the list. Escape will clear your search and hide the switcher.


## Technologies Used

SwitchFlit uses [Vue](https://vuejs.org) to power its UI, assisted by [Fuse.js](http://fusejs.io) for fuzzy-search.

## Future Enhancements

- Navigating the list of results
- Search on additional fields
- Customisable shortcuts

## Contributing

Development on SwitchFlit requires [Browserify](https://www.npmjs.com/package/browserify) / [Watchify](https://www.npmjs.com/package/watchify) to be installed globally,
along with [min.css](https://www.npmjs.com/package/min.css) for compiling CSS.

You should be able to get started on JS development with the following commands:

```
> cd switchflit
> npm install
> npm run watch
```

Run `npm run build-prod` to compress the dist version before opening a pull request.

The CSS is super basic at this stage, `npm run build-css` to compile.
