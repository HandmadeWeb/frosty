[![MIT Licensed](https://img.shields.io/badge/license-MIT-blue.svg?style=flat-square)](LICENSE.md)

Frosty provides easy access to fetch Ajax content via Alpine.Js in Statamic.

## Requirements

* PHP 8.0 or higher
* Statamic 3.1 or higher

## Installation

You can install the package via composer:

```shell
composer require handmadeweb/frosty
```
Then be sure to load Alpine.js on any pages that you wish to use Frosty on.

## PHP Usage
Using Frosty in `PHP` is done by using the `class` (see class instructions)

## Blade Usage
Using Frosty in `Blade` can be done by using the `frosty` blade directive or by using the `class` (see class instructions)

```blade
@frosty(string $content = null, array | Collection $context = [], string $endpoint = null, bool $antlers = false)
```

You can also use named arguments in PHP 8+ to specify particular parameters.
```blade
@frosty(content: 'Loading', endpoint: '/ajax/sponsors')
```

### Pulling in content from a url.

```blade
@frosty(endpoint: '/ajax/sponsors')
```

### Pulling in content from a route.
```blade
@frosty(endpoint: route('ajax.sponsors', 'featured'))
```

### Using initial content then pulling new content.
```blade
@frosty(content: '<p>Finding something juicy!</p>', endpoint: route('ajax.news'))
```

### Using antlers in content.
```blade
@frosty(content: '<p>Finding something @{{ zingword | ucfirst }}</p>', context: ['zingword' => 'amazing'], endpoint: route('ajax.news'))
```

## Antlers Usage
Using Frosty in `Antlers` can be done by using the `frosty` tag or if you are using an `.antlers.php` template file by using the `class` (see class instructions)

You can use the tag as either `frosty:fetch` or just `frosty`, I like `frosty:fetch` a little more though as it describes what it is doing.

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
The `\HandmadeWeb\Frosty\Frosty` class provides a way to easily generate code like the below.

```blade
<div x-data 
    x-init="fetch('/url-example')
        .then(response => response.text())
        .then(html => $el.innerHTML = html)"
>Initial content example</div>
```

You can do this by newing up the class.
```php
new Frosty(string $content = null, array | Collection $context = [], string $endpoint = null, bool $antlers = false)
```
Or by using the make method.
```php
Frosty::make(string $content = null, array | Collection $context = [], string $endpoint = null, bool $antlers = false)
```
You can also use named arguments in PHP 8+ to specify particular parameters.
```php
$frosty = Frosty::make(endpoint: '/ajax/random-quote');
```

All parameters are optional on init and can be individually defined later on.
```php
$frosty = Frosty::make();
$frosty->withContent($content); // string
$frosty->withContext($context); // \Statamic\Tags\Context or \Illuminate\Support\Collection (Used to provide Cascaded variables to the content)
$frosty->withEndpoint($endpoint); // string
$frosty->withAntlers(false); // bool
```

When using the tag, you'll specify if the endpoint is a url or a route, however when using the class directly, the endpoint is assumed to be a url string, if you wish to pass a route to it instead, then you are welcome to do that.

Unlike when using the Frosty tag, the Frosty class can directly accept parameters on the route below.
```php
Frosty::make()->withEndpoint(route('ajax.cart', $user->id())
```

When you are ready to output the content, then you may call the render method.
```php
Frosty::make()
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