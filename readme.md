# SwitchFlit

__NOTE: This module is in very early development - use at your own risk!__

A plug-and-play quick-switch UI for SilverStripe DataObjects.

## Premise

Quick-Switcher UIs are super useful for power users, and available today in a variety of applications and forms, such as Slack, Sublime Text, and Spotlight. With SwitchFlit, you can specify a DataObject's Name and Link fields and immediately enable a basic Quick-Switcher in your web app.

## Installation / Configuration

`composer require cheddam/silverstripe-switchflit`

Add configuration for one or more of your DataObjects as follows:

```yaml
SwitchFlit:
  models:
    MyDataObject:
      name: Title
      link: Link
```

Now add the SwitchFlit template to (the end of) your layout, specifying the model you configured:

```html
...
    <p>Other content</p>
</div>

<% include SwitchFlit Model="MyDataObject" %>
```

You should now be able to invoke the Switcher with Command + K on macOS, or CTRL + K on Windows.

SwitchFlit uses [Fuse.js]() to provide fuzzy-search on the Name field you specified for your DataObject. Pressing Enter will send you to the first result in the list. Escape will clear your search and hide the switcher.

## Future Enhancements

- Navigating the list of results
- Search on additional fields
- Customisable shortcuts
- 'Clicking away' from the Switcher

## Contributing

SwitchFlit is powered by [Vue](https://vuejs.org), so you will have a better time if you've toyed with that before.
It also requires [Watchify](https://github.com/substack/watchify) to be installed globally.

You should be able to get started on JS development with the following commands:

```
> cd switchflit
> npm install
> npm run watch
```

Run `npm run build-prod` to compress the dist version before opening a pull request.

The CSS is super basic at this stage, `npm run build-css` to compile.
