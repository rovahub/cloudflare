# Cloudflare DNS partner panel

## Installation

```bash
composer require rovahub/cloudflare
```

For version <= 5.4:

Add to section `providers` of `config/app.php`:

```php
// config/app.php
'providers' => [
    ...
    Rovahub\Cloudflare\Providers\CloudflareServiceProvider::class,
];
```

And add to `aliases` section:

```php
// config/app.php
'aliases' => [
    ...
    'Cloudflare' => Rovahub\Cloudflare\Facades\CloudflareFacade::class,
];
```

All assets resource will be manage in config file so we need to publish config to use.

```bash
php artisan vendor:publish --provider="Rovahub\Cloudflare\Providers\CloudflareServiceProvider" --tag=config
```

## Contributors

- [Quy Nguyen](https://github.com/ngocquy020196)

## License
[MIT](LICENSE) © [RovaHub Technologies](https://rovahub.com)
