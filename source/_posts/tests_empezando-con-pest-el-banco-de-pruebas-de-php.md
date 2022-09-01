---
extends: _layouts.post
section: content
title: Primero pasos con PEST el Framework de pruebas de PHP
date: 2022-09-01
description: Tutorial sobre la configuración y desarrollo de pruebas con el Framework PEST. Con este Framework de pruebas o tests, podremos simplificar el código de pruebas. El Framework ha sido desarrollado por Nuno Maduro, un referente en la comunidad Laravel.
categories: [php, laravel, tests]
---

En este artículo voy a poner dos ejemplos de uso de **PEST** con **Laravel**. Para ello, voy a utilizar un ejemplo para test Unitario y otro para **Laravel Dusk** (test de navegador).

## Instalación y configuración del Framework PEST

Lo primero va a ser instalarlo. Para ello:

```bash
composer require pestphp/pest --dev --with-all-dependencies
```

Y como estamos en **Laravel**, pues el plugin para utilizarlo:

```bash
composer require pestphp/pest-plugin-laravel --dev
```

Y ahora hacemos la instalación:

```bash
php artisan pest:install
```

Lo primero es configurar el archivo `Tests\Pest.php` que se ha creado en la instalación:

```php
uses(TestCase::class)->in('Feature', 'Unit');
uses(DuskTestCase::class)->in('Browser');
```

Con esto, le estamos diciendo a **PEST** los archivos de configuración que debe utilizar en función del test que vamos a realizar. **PEST no utiliza clases, así que de alguna forma debemos decirle que tipo de configuración debe usar en función del tipo de prueba.** Esta es una de las ventajas de utilizar **PEST**, te ahorras todo el código de las clases.

## Test Unitarios con el Framework de pruebas PEST

Ahora creamos el archivo `Tests\Unit\PruebaTest.php` y dentro vamos a hacer una prueba básica con **PEST**:

```php 
<?php 

test('Puedo ver la página principal', function () {
    // Response
    $response = $this->get(route('home'));
    // Assert
    $response->assertOk();
});
```

Si te fijas, no hay clases, ni `namespaces`, ni nada... solo una función. Podemos hacer algo más elaborado, como añadir elementos a la base de datos:

```php 
<?php 

use App\Models\User;

test('Puedo crear un usuario', function () {
    $usuario = User::factory()->create([
        'name' => 'Damián',
        'email' => 'ejemplo@email.com',
        'address' => null,
    ]);
 
    expect($usuario)
        ->name->toBe('Damián')
        ->address->toBeNull();
});
```

Podemos añadir funcionalidades nuevas:

```php 
<?php 

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

beforeEach(function() {
    $this->user = User::factory()->create([
        'name' => 'Damián',
        'email' => 'ejemplo@email.com',
        'address' => null,
    ]);
});

test('Puedo ver el listado de usuarios', function () {
    test() // Helper para no usar $this->
        ->actingAs($this->user)
        ->visit('/dashboard/users')
        ->assertSee('Damián');
});
```

Veamos las cosas nuevas que hemos añadido:

```php 
uses(RefreshDatabase::class);
```

Nos permite incorporar la clase para que la base de datos se refresque en cada test. Podemos usar `uses()` para añadir cualquier dependencia que necesitemos.

```php 
beforeEach(function() {});
``` 

Nos permite realizar operaciones antes de cada test, por lo tanto es un equivalente al método `setUp()`. Existen otros métodos que podemos utilizar, el listado completo es:

- `beforeAll()`: Se ejecuta antes de todos los test. Se ejecutará sólo una vez.
- `beforeEach()`: Se ejecuta antes de cada test. Se ejecutará tantas veces como test tengamos.
- `afterEach()`: Se ejecuta después de cada test. Se ejecutará tantas veces como test tengamos.
- `afterAll()`: Se ejecuta al finalizar los tests. Se ejecutará sólo una vez.

## Test de navegador con el Framework de pruebas PEST y Laravel Dusk 

Veamos un ejemplo usando sólo **Laravel Dusk**:

```php 
<?php

namespace Tests\Browser;

use App\Models\User;
use Tests\DuskTestCase;
use Laravel\Dusk\Browser;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class CrudTest extends DuskTestCase
{
    use DatabaseMigrations;

    private User $admin;

    private User $user;

    public function setUp() :void
    {
        parent::setUp();

        $this->admin = User::factory()->create([
            'id' => '8c9d4152-c85c-423e-81f4-521ffde5e908',
            'name' => 'Elvis Presley',
            'email' => 'elvis@presley.com',
            'role' => 0
        ]);
        $this->user = User::factory()->create([
            'id' => '8c9d4152-c85c-423e-81f4-521ffde5e909',
            'name' => 'Michael Jackson',
            'email' => 'michael@jackson.com',
            'role' => 3
        ]);
    }

    /**
     * Admin can see users
     *
     * @return void
     */
    public function test_admin_can_see_users()
    {
        $this->browse(function (Browser $browser) {
            $browser
                ->loginAs($this->admin)
                ->visit(route('dashboard.users.index'))
                ->assertSee('Usuarios')
                ->assertSee('Listado')
                ->assertSee('Elvis Presley')
                ->assertSee('elvis@presley.com');
        });
    }

    /**
     * Users cannot see other users
     *
     * @return void
     */
    public function test_user_can_not_see_users()
    {
        $this->browse(function (Browser $browser) {
            $browser
                ->loginAs($this->user)
                ->visit(route('dashboard.users.index'))
                ->assertDontSee('Usuarios')
                ->assertDontSee('Listado')
                ->assertDontSee('Elvis Presley')
                ->assertDontSee('elvis@presley.com');
        });
    }
}
```

En el ejemplo hemos creado dos usuarios, uno con rol de administrador y el otro de usuario. La página sólo puede ser accedida por un administrador.

Ahora, veamos el mismo ejemplo con **PEST**:

```php 
<?php

use App\Models\User;
use Laravel\Dusk\Browser;
use Illuminate\Foundation\Testing\DatabaseMigrations;

uses(DatabaseMigrations::class);

beforeEach(function() {
    $this->admin = User::factory()->create([
        'id' => '8c9d4152-c85c-423e-81f4-521ffde5e908',
        'name' => 'Elvis Presley',
        'email' => 'elvis@presley.com',
        'role' => 0
    ]);
    $this->user = User::factory()->create([
        'id' => '8c9d4152-c85c-423e-81f4-521ffde5e909',
        'name' => 'Michael Jackson',
        'email' => 'michael@jackson.com',
        'role' => 3
    ]);
});

test('Admin can see users', function () {
    $this->browse(function (Browser $browser) {
        $browser
            ->loginAs($this->admin)
            ->visit(route('dashboard.users.index'))
            ->assertSee('Usuarios')
            ->assertSee('Listado')
            ->assertSee('Elvis Presley')
            ->assertSee('elvis@presley.com');
    });
});

test('User cannot see users', function () {
    $this->browse(function (Browser $browser) {
        $browser
            ->loginAs($this->user)
            ->visit(route('dashboard.users.index'))
            ->assertDontSee('Usuarios')
            ->assertDontSee('Listado')
            ->assertDontSee('Elvis Presley')
            ->assertDontSee('elvis@presley.com');
    });
});
```

Al final es todo cuestión de preferencias. Yo me quedo con **PEST**.
