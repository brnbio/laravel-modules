# laravel-modules

Easy and performant module management for laravel.

## Installation

```bash
composer require brnbio/laravel-modules
```

```bash
php artisan vendor:publish --provider="Brnbio\LaravelModules\ServiceProvider" --tag="config"
```

## Usage

#### Load module

Add module config to _config/modules.php_
```php
'foo' => [
    'name' => 'Foobar',
    'namespace' => 'App\Modules\Foobar',
    'enabled' => true,
]
```

#### Config options

**name**
Name of the module

**namespace**
Namespace of the module

**enabled**
Enable or disable the module (default: false)

**seeder**
Seeder class name (default: null)

**src**
Path to the module source
