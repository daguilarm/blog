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
        $app->singleton('Illuminate\Contracts\Http\Kernel', 'Tests\HttpKernel');
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

- https://github.com/spatie/laravel-permission/blob/master/tests/TestCase.php
- https://github.com/livewire/livewire/blob/master/tests/Unit/TestCase.php

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

- https://laracasts.com/discuss/channels/livewire/package-development-target-class-livewire-does-not-exist

Al principio sólo incluía el **Service Provider** de `BelichTablesServiceProvider::class` hasta que he decubierto que había que incluir también el de `LivewireServiceProvider::class`. Esto me ha llevado casi una hora delante del ordenador... 

Por último, el **Trait** `TestSeed::class`, solo sirve para rellenar la base de datos:

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
