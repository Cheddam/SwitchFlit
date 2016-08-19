# Contributing

Pull requests are more than welcome on this project! I am aiming to keep the scope of the module
relatively small, but there are a lot of QOL improvements to be made.

## Development

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

## Pull Requests

PRs should contain a good description of the problem you are solving (whether a bugfix or a feature),
along with a demo if there are any significant changes introduced. PRs may be closed if the
functionality introduced is considered outside the scope of this project, but an explanation
will always be provided.

