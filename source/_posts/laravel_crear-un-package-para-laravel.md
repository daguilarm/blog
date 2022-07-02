---
extends: _layouts.post
section: content
title: Crear un package para Laravel
date: 2020-01-20
description: Creación de un package para Laravel desde cero.
categories: [laravel, packages, php, frameworks]
---

Una buena forma de ordenar y reutilizar nuestro código de **Laravel**, es mediante el uso de *packages*. En este artículo, vamos a centrarnos en la creación y desarrollo de *packages* propios, pero si estás interesado en *packages* de terceros, aquí tienes una lista con los imprescindibles (por lo menos para mi...):

- https://daguilar.dev/blog/laravel_packages-imprescindibles-para-laravel/

Lo primero es crear la carpeta para nuestro *package*. Con un Mac, entramos al terminal (yo suelo utilizar la carpeta *sites* para mis proyectos):

```bash
mkdir sites/my-package
```

Si no tenemos instalado Composer, lo instalamos:

- https://getcomposer.org/

Ahora, nos vamos al terminal y entramos en la carpeta de nuestro *package*:

```bash
cd sites/my-package
```

E iniciamos **Composer**:

```bash
composer init
```

Ahora **Composer** empezará a hacernos preguntas sobre el *package* y el autor... podemos saltarlas o añadir la información. El resultado final, será la de la creación del archivo `composer.json`, que tendrá un aspecto similar a este:

```javascript
{
    "name": "daguilarm/belich",
    "description": "Laravel admin dashboard",
    "license": "MIT",
    "authors": [
        {
            "name": "daguilarm",
            "email": "damian.aguilarm@gmail.com"
        }
    ],
    "require": {},
    "minimum-stability": "dev"
}
```

El siguiente paso es el de crear un *ServiceProvider*. Para ello, creamos la carpeta `sites/my-package/src` y le añadimos el archivo `BelichServiceProvider.php` o como quieras llamarlo.

Ahora es el momento de añadir a nuestro archivo `composer.json`, nuestro *ServiceProvider* y el *Namespace*:

```javascript
{
    "name": "daguilarm/belich",
    "description": "Laravel admin dashboard",
    "license": "MIT",
    "authors": [
        {
            "name": "daguilarm",
            "email": "damian.aguilarm@gmail.com"
        }
    ],
    "extra": {
        "laravel": {
            "providers": [
                "Daguilarm\\Belich\\ServiceProvider"
            ]
        }
    },
    "autoload": {
        "psr-4": {
            "Daguilarm\\Belich\\": "src/"
        }
    },
    "require": {},
    "minimum-stability": "dev"
}
```

El *namespace* del *package*, sería: `Daguilarm\Belich` y la ubicación del *ServiceProvider*: `Daguilarm\Belich\ServiceProvider`.

Ahora nos toca configurar nuestro *ServiceProvider*. Este archivo debe de tener la siguiente estructura básica:

```php
<?php

namespace Daguilarm\Belich;

use Illuminate\Support\ServiceProvider as Provider;

final class ServiceProvider extends Provider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot(): void
    {
        //
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register(): void
    {
        // 
    }
}
```

Ahora vienen las preguntas importantes:

### ¿Como configurar las rutas del package?

Podemos crear un método y añadir los archivos de rutas:

```php
/**
 * Register the package routes
 *
 * @return void
 */
protected function registerRoutes(): void
{
    require_once __DIR__ . '/../routes/AuthRoutes.php';
    require_once __DIR__ . '/../routes/ResolveRoutes.php';
    ...
}
```
Estos archivos, los crearemos en `sites/my-package/routes`, y son iguales que los archivos de rutas de **Laravel**:

```php
//sites/my-package/routes/AuthRoutes.php
<?php

Route::group(['middleware' => ['web']], static function (): void {

    // Authentication Routes...
    Route::get(Belich::path() . '/login', 'Daguilarm\Belich\App\Http\Controllers\Auth\LoginController@showLoginForm')->name('login');
});
```

Y luego, desde el método `boot()`, llamamos las rutas:

```php
<?php

namespace Daguilarm\Belich;

use Illuminate\Support\ServiceProvider as Provider;

final class ServiceProvider extends Provider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot(): void
    {
        //Routes 
        $this->registerRoutes();
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register(): void
    {
        // 
    }
}
```

### ¿Como configurar los recursos y las vistas?

Vamos a utilizar la misma técnica de antes. A nuestro método `boot()`, le añadimos:

```php
<?php

namespace Daguilarm\Belich;

use Illuminate\Support\ServiceProvider as Provider;

final class ServiceProvider extends Provider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot(): void
    {
        //Routes 
        $this->registerRoutes();

        //Resources 
        $this->registerResources();
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register(): void
    {
        // 
    }
}
```

Y nuestro nuevo método, sería así:

```php
/**
 * Register the package resources
 *
 * @return void
 */
protected function registerResources(): void
{
    //Load the views
    $this->loadViewsFrom(__DIR__ . '/../resources/views', 'belich');
    //Load language translations...
    $this->loadTranslationsFrom(resource_path('lang/vendor/belich'), 'belich');
    $this->loadJsonTranslationsFrom(resource_path('lang/vendor/belich'), 'belich');
}
```

Lo que estamos haciendo, es indicarle a **Laravel**, en que rutas vamos a guardar nuestros recursos:

- `sites/my-package/resources/view`, para nuestras vistas.
- `sites/laravel/resources/lang/vendor/belich`, para nuestros archivos de idioma (la ruta es del proyecto de Laravel, no del *package*).

Ahora, para acceder a las vistas del *package*, debemos utilizar:

```php
view('belich::path.to.the.view')
```

y lo mismo para los archivos de idioma:

```php
trans('belich::path.to.the.file')
```

### ¿Como configurar las migraciones?

Seguimos la estructura anterior, y añadimos:

```php
<?php

namespace Daguilarm\Belich;

use Illuminate\Support\ServiceProvider as Provider;

final class ServiceProvider extends Provider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot(): void
    {

        //Routes 
        $this->registerRoutes();

        //Resources 
        $this->registerResources();

        //Migrations 
        $this->registerMigrations();
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register(): void
    {
        // 
    }
}
```

Ahora, solo tenemos que indicar, en que directorio guardamos las migraciones de nuestro *package*:

```php
//sites/my-package/database/migrations
/**
 * Register the package migrations
 *
 * @return void
 */
protected function registerMigrations(): void
{
    $this->loadMigrationsFrom(__DIR__.'/../database/migrations');
}
```

### ¿Como configurar comandos de consola?

Seguimos la estructura anterior, y añadimos:

```php
<?php

namespace Daguilarm\Belich;

use Illuminate\Support\ServiceProvider as Provider;

final class ServiceProvider extends Provider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot(): void
    {
        //Routes 
        $this->registerRoutes();

        //Resources 
        $this->registerResources();

        //Migrations 
        $this->registerMigrations();

        //Console 
        $this->registerConsole();
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register(): void
    {
        // 
    }
}
```

Y creamos el método:

```php
/**
 * Register the package console commands
 *
 * @return void
 */
protected function registerConsole(): void
{
    if ($this->app->runningInConsole()) {
        $this->commands([
            \Daguilarm\Belich\App\Console\Commands\CardCommand::class,
            \Daguilarm\Belich\App\Console\Commands\ComponentCommand::class,
            \Daguilarm\Belich\App\Console\Commands\MetricCommand::class,
        ]);
    }
}
```

### Extra

Si quieres saber como configurar el *package* para que se pueda utilizar desde **Packagist**:

[https://daguilar.dev/blog/packages_configurar-github-webhooks-para-packagist/](https://daguilar.dev/blog/packages_configurar-github-webhooks-para-packagist/)

Y si quieres hacer tests a un package:

[https://daguilar.dev/blog/package_configurando-un-package-de-laravel-y-livewire-para-hacer-tests/](https://daguilar.dev/blog/package_configurando-un-package-de-laravel-y-livewire-para-hacer-tests/)
