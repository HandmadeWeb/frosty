[![MIT Licensed](https://img.shields.io/badge/license-MIT-blue.svg?style=flat-square)](LICENSE.md)

Frosty provides easy access to fetch Ajax content in Statamic.

## Requirements

* PHP 8.0 or higher
* Statamic 3.1 or higher

## Installation

You can install the package via composer:

```shell
composer require handmadeweb/frosty
```

### Copy the package config to your local config with the publish command:

```shell
php artisan vendor:publish --tag="config" --provider="HandmadeWeb\Frosty\ServiceProvider"
```

### Prepare for Usage
#### Native Method
If you aren't using Alpine Js in your application then you'll need to load [handmadeweb/datafetcher.js](https://github.com/HandmadeWeb/datafetcher.js) in your footer, you can either do this manually, or via the provided helpers for Alpine: `{{ frosty:scripts }}`, Blade: `@frostyScripts` or PHP: `\HandmadeWeb\Frosty\Frosty::scripts();`

#### Alpine Js Method

If you are using Alpine Js in your application then you may update your Frosty configuration to use Alpine.
```php
/*
* Javascript Mode
*
* Which Javascript mode to use?
*
* native: uses https://github.com/handmadeweb/datafetcher.js
* - If you aren't using Alpine Js in your application then you'll need to load handmadeweb/datafetcher.js in your footer.
* - You can either do this manually, or via the provided helpers for Alpine: `{{ frosty:scripts }}`
* - Blade: `@frostyScripts` or PHP: `\HandmadeWeb\Frosty\Frosty::scripts();`
*
* alpine: uses Alpine.Js, be sure to load it.
*/
'mode' => 'alpine',
```


## Antlers Usage
Using Frosty in `Antlers` can be done by using the `frosty` tag or if you are using an `.antlers.php` template file by using the `class` (see class instructions)

You can use the tag as either `frosty:fetch` or just `frosty`, I like `frosty:fetch` a little more though as it describes what it is doing.

### Pulling in content from a url.
The url can be anywhere.
```antlers
{{ frosty:fetch url="/ajax/signup-form" }}
```
Or
```antlers
{{ frosty:fetch endpoint="/ajax/signup-form" }}
```

### Pulling in content from a route.
Routes must be a GET route and cannot currently accept parameters.
```antlers
{{ frosty:fetch route="ajax.signup-form" }}
```

Please note that the above three examples cannot be combined into a single tag call.
```antlers
{{ frosty:fetch endpoint="/ajax/signup-form" url="/ajax/signup-form" route="ajax.signup-form" }}
{{ frosty:fetch route="ajax.signup-form" endpoint="/ajax/signup-form" url="/ajax/signup-form" }}
```
The first found parameter will be used, parameters are checked in the order: endpoint, url, route.

### Using initial content then pulling new content.
This works with both the route and url options.
```antlers
{{ frosty:fetch route="ajax.news" }}
    <p>Finding something juicy!</p>
{{ /frosty:fetch }}
```

## Blade Usage
Using Frosty in `Blade` can be done by using the `frosty` blade directive or by using the `class` (see class instructions)
The blade directive currently doesn't accept providing content or context, If you need to use that functionality the you'll need to use the class chaining method.

```blade
@frosty(string $endpoint = null)
```

You can also use named arguments in PHP 8+ to specify particular parameters.
```blade
@frosty(endpoint: '/ajax/sponsors')
```

### Pulling in content from a url.

```blade
@frosty('/ajax/sponsors')
```

### Pulling in content from a route.
```blade
@frosty(route('ajax.sponsors', 'featured'))
```

## Class Usage
New up the class.
```php
new Frosty(string $endpoint = null)
```
Or use the make method.
```php
Frosty::make(string $endpoint = null)
```
You can also use named arguments in PHP 8+ to specify particular parameters.
```php
$frosty = Frosty::make(endpoint: '/ajax/random-quote');
```

Aditional methods can be chained to add content and context, or to set the endpoint.
```php
$frosty = Frosty::make();
$frosty->withContent($content); // string
$frosty->withContext($context); // \Statamic\Tags\Context or \Illuminate\Support\Collection (Used to provide Cascaded variables to the content)
$frosty->withEndpoint($endpoint); // string
```

When using the tag, you'll specify if the endpoint is a url or a route, however when using the class directly, the endpoint is assumed to be a url string, if you wish to pass a route to it instead, then you are welcome to do that.

Unlike when using the Frosty tag, the Frosty class can directly accept parameters on the route below.
```php
Frosty::make(route('ajax.cart', $user->id())
// or
Frosty::make()->withEndpoint(route('ajax.cart', $user->id())
```

When you are ready to output the content, then you may call the render method.
```php
Frosty::make()
    ->withContent($content) // Optional
    ->withContext($context) // Optional
    ->withEndpoint($endpoint) // Optional (could be set on class or make), If no endpoint has been set, then we won't bother trying to render.
    ->render();
```

## Changelog

Please see [CHANGELOG](https://statamic.com/addons/handmadeweb/frosty/release-notes) for more information what has changed recently.

## Contributing

Please see [CONTRIBUTING](https://github.com/handmadeweb/frosty/blob/main/CONTRIBUTING.md) for details.

## Credits

- [Handmade Web & Design](https://github.com/handmadeweb)
- [Michael Rook](https://github.com/michaelr0)
- [All Contributors](https://github.com/handmadeweb/frosty/graphs/contributors)

## License

The MIT License (MIT). Please see [License File](https://github.com/handmadeweb/frosty/blob/main/LICENSE) for more information.