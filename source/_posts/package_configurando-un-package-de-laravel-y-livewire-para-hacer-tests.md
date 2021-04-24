---
extends: _layouts.post
section: content
title: Configurando un package de Laravel y Livewire para hacer tests.
date: 2021-04-23
description: Por qué he cambiado mi proyecto a este sistema, y qué ventajas tiene frente al sistema tradicional de la ID
categories: [laravel, livewire, packages, tests]
---

Me he visto por primera vez ante la situación de tener que testear un *package* para **Laravel** que además estaba basado en **Livewire**. No ha sido fácil, y me ha llevado algo de tiempo tenerlo todo preparado.

Lo primero ha sido crear el archivo `TestCase.php` en la carpeta `./tests`. Dejo el archivo completo (que es del package [Belich Tables](https://github.com/daguilarm/belich-tables){.link-out}):

```php
<?php

namespace Daguilarm\BelichTables\Tests;

use Daguilarm\BelichTables\BelichTablesServiceProvider;
use Daguilarm\BelichTables\Tests\TestSeed;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\File;
use Livewire\LivewireServiceProvider;
use Orchestra\Testbench\TestCase as BaseTestCase;

class TestCase extends BaseTestCase
{
    use TestSeed;

    /**
     * Setup the test environment.
     */
    protected function setUp(): void
    {
        // Clean up the test
        $this->afterApplicationCreated(function () {
            $this->makeACleanSlate();
        });

        $this->beforeApplicationDestroyed(function () {
            $this->makeACleanSlate();
        });

        parent::setUp();

        // Seed the database
        $this->seedUsers();
        $this->seedProfiles();
    }

    /**
     * Load the service providers
     */
    protected function getPackageProviders($app)
    {
        return [
            BelichTablesServiceProvider::class,
            LivewireServiceProvider::class,
        ];
    }

    /**
     * Setup the testing environment
     */
    public function getEnvironmentSetUp($app)
    {
        // Setup the application
        $app['config']->set('view.paths', [
            __DIR__.'/views',
            resource_path('views'),
        ]);
        $app['config']->set('auth.providers.users.model', User::class);
        $app['config']->set('app.key', 'base64:Hupx3yAySikrM2/edkZQNQHslgDWYfiBfCuSThJ5SK8=');
        $app['config']->set('database.default', 'testbench');
        $app['config']->set('database.connections.testbench', [
            'driver'   => 'sqlite',
            'database' => ':memory:',
            'prefix'   => '',
        ]);

        // Populate the DB
        include_once __DIR__.'/../database/migrations/create_test_tables.php.stub';
        (new \CreateTestTables())->up();
    }

    /**
     * Clean up for the test
     */
    public function makeACleanSlate()
    {
        Artisan::call('view:clear');

        File::deleteDirectory($this->livewireViewsPath());
        File::deleteDirectory($this->livewireClassesPath());
        File::deleteDirectory($this->livewireTestsPath());
        File::delete(app()->bootstrapPath('cache/livewire-components.php'));
    }

    /**
     * Swap HTTP Kernel for application bootstrap
     */
    protected function resolveApplicationHttpKernel($app)
    {
        $app->singleton('Illuminate\Contracts\Http\Kernel', 'Daguilarm\BelichTables\Tests\HttpKernel');
    }

    /**
     * Set the path for the livewire classes
     */
    protected function livewireClassesPath($path = '')
    {
        return app_path('Http/Livewire'.($path ? '/'.$path : ''));
    }

    /**
     * Set the path for the livewire views
     */
    protected function livewireViewsPath($path = '')
    {
        return resource_path('views').'/livewire'.($path ? '/'.$path : '');
    }

    /**
     * Set the path for the livewire tests
     */
    protected function livewireTestsPath($path = '')
    {
        return base_path('tests/Feature/Livewire'.($path ? '/'.$path : ''));
    }
}
```
Antes de empezar tengo que aclarar que he tenido dos fuentes principales de información hasta llegar aquí:

- [https://github.com/spatie/laravel-permission/blob/master/tests/TestCase.php](https://github.com/spatie/laravel-permission/blob/master/tests/TestCase.php){.link-out}
- [https://github.com/livewire/livewire/blob/master/tests/Unit/TestCase.php](https://github.com/livewire/livewire/blob/master/tests/Unit/TestCase.php){.link-out}

La clave para conseguir que funcionara, ha estado aqui:

```php
/**
 * Load the service providers
 */
protected function getPackageProviders($app)
{
    return [
        BelichTablesServiceProvider::class,
        LivewireServiceProvider::class,
    ];
}
```

El problema era que cada vez que hacía un test, me daba el mismo error:

    Illuminate\Contracts\Container\BindingResolutionException: Target class [livewire] does not exist.

La solución la encontré aqui:

- [https://laracasts.com/discuss/channels/livewire/package-development-target-class-livewire-does-not-exist](https://laracasts.com/discuss/channels/livewire/package-development-target-class-livewire-does-not-exist){.link-out}

Al principio sólo incluía el **Service Provider** de `BelichTablesServiceProvider::class` hasta que he decubierto que había que incluir también el de `LivewireServiceProvider::class`. Esto me ha llevado casi una hora delante del ordenador... 

Sin olvidar el **Trait** `TestSeed::class`, que solo sirve para rellenar la base de datos:

```php
<?php

namespace Daguilarm\BelichTables\Tests;

use Daguilarm\BelichTables\Tests\Models\Profile;
use Daguilarm\BelichTables\Tests\Models\User;

trait TestSeed
{
    protected function seedUsers()
    {
        return User::insert([
            [ 
                'id' => 1, 
                'name' => 'Damián Aguilar', 
                'email' => 'damian.aguilar@email.com', 
                'active' => 1, 
                'date' => '2021-04-22 00:00:01'
            ],
            [/* ... */],
        ]);
    }

    protected function seedProfiles()
    {
        return Profile::insert([
            [
                'id' => 1, 
                'user_id' => 1, 
                'profile_telephone' => '000000001'
            ],
            [/* ... */],
        ]);
    }
}
```

Otro aspecto importante si quieres utilizar los test que tiene **Livewire** disponibles, es tener en cuenta que hay que añadir todo el `middleware`, tal y como indicamos en el método `resolveApplicationHttpKernel($app)`:

```php 
/**
 * Swap HTTP Kernel for application bootstrap
 */
protected function resolveApplicationHttpKernel($app)
{
    $app->singleton('Illuminate\Contracts\Http\Kernel', 'Daguilarm\BelichTables\Tests\HttpKernel');
}
```

Recuerdo que en nuestro `TestCase` hemos incluido este archivo, asi que tenemos que crearlo en la ruta que hemos especificado en el `singleton`. El archivo lo podemos encontrar en:

- [https://github.com/livewire/livewire/blob/master/tests/HttpKernel.php](https://github.com/livewire/livewire/blob/master/tests/HttpKernel.php){.link-out}

Y en caso que cambie de ubicación, lo copio aquí:

```php 
<?php

namespace Daguilarm\BelichTables\Tests;

use Illuminate\Foundation\Http\Kernel;

class HttpKernel extends Kernel
{
    /**
     * The application's global HTTP middleware stack.
     *
     * These middleware are run during every request to your application.
     *
     * @var array
     */
    protected $middleware = [
        \Illuminate\Foundation\Http\Middleware\CheckForMaintenanceMode::class,
        \Illuminate\Foundation\Http\Middleware\ValidatePostSize::class,
        \Illuminate\Foundation\Http\Middleware\TrimStrings::class,
        \Illuminate\Foundation\Http\Middleware\ConvertEmptyStringsToNull::class,
    ];

    /**
     * The application's route middleware groups.
     *
     * @var array
     */
    protected $middlewareGroups = [
        'web' => [
            \Illuminate\Cookie\Middleware\EncryptCookies::class,
            \Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse::class,
            \Illuminate\Session\Middleware\StartSession::class,
            \Illuminate\View\Middleware\ShareErrorsFromSession::class,
            \Illuminate\Foundation\Http\Middleware\VerifyCsrfToken::class,
            \Illuminate\Routing\Middleware\SubstituteBindings::class,
        ],

        'api' => [
            'throttle:60,1',
            'bindings',
        ],
    ];

    /**
     * The application's route middleware.
     *
     * These middleware may be assigned to groups or used individually.
     *
     * @var array
     */
    protected $routeMiddleware = [
        'auth' => \Illuminate\Auth\Middleware\Authenticate::class,
        'auth.basic' => \Illuminate\Auth\Middleware\AuthenticateWithBasicAuth::class,
        'bindings' => \Illuminate\Routing\Middleware\SubstituteBindings::class,
        'cache.headers' => \Illuminate\Http\Middleware\SetCacheHeaders::class,
        'can' => \Illuminate\Auth\Middleware\Authorize::class,
        'guest' => \Orchestra\Testbench\Http\Middleware\RedirectIfAuthenticated::class,
        'signed' => \Illuminate\Routing\Middleware\ValidateSignature::class,
        'throttle' => \Illuminate\Routing\Middleware\ThrottleRequests::class,
        'verified' => \Illuminate\Auth\Middleware\EnsureEmailIsVerified::class,
    ];

    /**
     * The priority-sorted list of middleware.
     *
     * This forces non-global middleware to always be in the given order.
     *
     * @var array
     */
    protected $middlewarePriority = [
        \Illuminate\Session\Middleware\StartSession::class,
        \Illuminate\View\Middleware\ShareErrorsFromSession::class,
        \Illuminate\Auth\Middleware\Authenticate::class,
        \Illuminate\Session\Middleware\AuthenticateSession::class,
        \Illuminate\Routing\Middleware\SubstituteBindings::class,
        \Illuminate\Auth\Middleware\Authorize::class,
    ];
}
```

Como recordatorio... no olvides cambiar los `namespaces` y adaptarlos a tu proyecto.
