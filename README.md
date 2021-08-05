[![MIT Licensed](https://img.shields.io/badge/license-MIT-blue.svg?style=flat-square)](LICENSE.md)

Frosty provides easy access to fetch Ajax content via Alpine.Js in Statamic.

## Requirements

* Statamic 3.1 or higher

## Installation

You can install the package via composer:

```shell
composer require handmadeweb/frosty
```
Then be sure to load Alpine.js on any pages that you wish to use Frosty on.

## Tag Usage

### Pulling in content from a url.
The url can be anywhere.
```antlers
{{ frosty:fetch url="/ajax/signup-form" }}
```

### Pulling in content from a route.
Routes must be a GET route and cannot currently accept parameters.
```antlers
{{ frosty:fetch route="ajax.signup-form" }}
```

Please note that the above two examples cannot be combined into a single tag call.
```antlers
{{ frosty:fetch url="/ajax/signup-form" route="ajax.signup-form" }}
{{ frosty:fetch route="ajax.signup-form" url="/ajax/signup-form" }}
```
The url will always be used as the endpoint location.

### Using initial content then pulling new content.
This works with both the route and url options.
```antlers
{{ frosty:fetch route="ajax.news" }}
    <p>Finding something juicy!</p>
{{ /frosty:fetch }}
```

## Class Usage
The `\HandmadeWeb\Frosty\FrostyFetcher` class provides a way to easily generate code like the below.

```blade
<div x-data 
    x-init="fetch('/url-example')
        .then(response => response.text())
        .then(html => $el.innerHTML = html)"
>Initial content example</div>
```

You can do this by newing up the class.
```php
new FrostyFetcher(string $content = null, ?Collection $context = null, string $endpoint = null, bool $shouldUseAntlers = false)
```
Or by using the make method.
```php
FrostyFetcher::make(string $content = null, ?Collection $context = null, string $endpoint = null, bool $shouldUseAntlers = false)
```

All parameters are optional on init and can be individually defined later on.
```php
$frosty = FrostyFetcher::make();
$frosty->withContent($content); // string
$frosty->withContext($context); // \Statamic\Tags\Context or \Illuminate\Support\Collection (Used to provide Cascaded variables to the content)
$frosty->withEndpoint($endpoint); // string
$frosty->withAntlers(false); // bool
```
When using the tag, you'll specify if the endpoint is a url or a route, however when using the class directly, the endpoint is assumed to be a url string, if you wish to pass a route to it instead, then you are welcome to do that.

Unlike when using the Frosty tag, the FrostyFetcher class can directly accept parameters on the route below.
```php
FrostyFetcher::make()->withEndpoint(route('my-awesome-route'))
```

When you are ready to output the content, then you may call the render method.
```php
FrostyFetcher::make()
    ->withContent($content)
    ->withContext($context)
    ->withEndpoint($endpoint)
    ->withAntlers(false)
    ->render();
```

## View
Should you wish to override the vendor/handmadeweb/frosty/resources/views/fetcher.blade.php view, you are welcome to do that, by placing `fetcher.blade.php`, `fetcher.antlers.php` or `fetcher.antlers.html` in the resources/vendor/frosty directory from the root of your project.
The class will be passed down to the view and will be called `frosty`.
You may then use the `$frosty->content()` and `$frosty->endpoint()` methods in your view override.

## Changelog

Please see [CHANGELOG](https://statamic.com/addons/handmadeweb/frosty/release-notes) for more information what has changed recently.

## Contributing

Please see [CONTRIBUTING](https://github.com/handmadeweb/frosty/blob/main/CONTRIBUTING.md) for details.

## Credits

- [Handmade Web & Design](https://github.com/handmadeweb)
- [Michael Rook](https://github.com/michaelr0)
- [All Contributors](https://github.com/handmadeweb/frosty/graphs/contributors)

## License

The MIT License (MIT). Please see [License File](https://github.com/handmadeweb/frosty/blob/main/LICENSE.md) for more information.