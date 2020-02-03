---
extends: _layouts.post
section: content
title: Macros personalizados para Laravel Dusk
date: 2020-02-03
description: Listado de macros para Laravel dusk que pueden ser de utilidad.
categories: [laravel, php, tests]
---

A día de hoy, es imposible realizar un desarrollo (en cualquier lenguaje de programación), sin realizar pruebas. En Laravel disponemos de varias herramientas para realizar nuestras pruebas:

- Http tests (basados en PhpUnit).
- Browser tests (basados en Selenium/WebDriver protocol).

En este artículo, vamos a centrarnos en el segundo, el utilizado por [Laravel Dusk](https://laravel.com/docs/6.x/dusk){.link-out}, y que nos va a permitir testear nuestro código desde un **Navegador Web**, y por tanto, pudiendo probar `javascript`.

Laravel dusk, al igual que otras partes del código de Laravel, incluyen el `trait Macroable`, el cual nos permite crear métodos personalizados para **Dusk**.

Este `trait`, nos permitirá hacer cosas como esta:

```php
Response::macro('lower', function ($value) {
  return Response::make(strtoupper($value));
});
```
Que podremos utilizar así:

```php
return response()->lower('foo');
```

Nuestros `traits`, debemos añadirlos al método `boot()` the un `ServiceProvider`, por lo que lo mejor, es crear nuestro própio `ServiceProvider`, por ejemplo:

```php
//app\Providers\DuskServiceProvider.php
namespace App\Providers;

use Facebook\WebDriver\WebDriverBy;
use Illuminate\Support\ServiceProvider;
use Laravel\Dusk\Browser;

class DuskServiceProvider extends ServiceProvider
{
    public static $except = [];

    /**
     * Register the Dusk's browser macros.
     *
     * @return void
     */
    public function boot()
    {
        // Assert a field exists
        Browser::macro('assertExists', function ($element) {
            return count($this->driver->findElements(WebDriverBy::cssSelector($element))) > 0
                ? true
                : false;
        });

        // Add value to hidden field
        Browser::macro('fillHidden', function ($name , $value) {
            $this->script("document.getElementsByName('$name')[0].value = '$value'");

            return $this;
        });

        // Select a option (using its position) from a select
        Browser::macro('selectOption', function ($element, $position) {
            $this->script("$('select[name=\"{$element}\"] option:eq({$position})').attr('selected', 'selected');");

            return $this;
        });

        // Select a random option from a radio button
        Browser::macro('selectRadioOption', function ($radioElement) {
            $radio_options = $this->driver->findElements(WebDriverBy::name($radioElement));
            $radio_options[array_rand($radio_options)]->click();
        });

        // Wait until the page is reload
        Browser::macro('waitForReload', function () {
            $this->driver->executeScript('window.oldPageStillIn = {}');
            $callable();

            return $this->waitUntil("return typeof window.oldPageStillIn === 'undefined';");
        });
    }
}
```

Veamos uno a uno, los ejemplos mostrados anteriormente:

1. assertExists

Este método, se utiliza para verificar si un elemento existe o no. Es muy útil para ser utilizado como condición para ejecutar una prueba o no realizarla.

```php
public function test_field_exists()
{
    $this->browse(function (Browser $browser) {
        // Testing forms
        $browser
            ->loginAs(App\User::find(1))
            ->visit('dashboard/user/create')
            ->assertExists('.selectField');
    });
}
```

Fuente: [https://www.5balloons.info/using-browser-macros-in-laravel-dusk/](https://www.5balloons.info/using-browser-macros-in-laravel-dusk/){.link-out}

2. fillHidden

Nos permite añadir un valor por defecto a un campo oculto:

```php
public function test_add_value_to_hidden_field()
{
    $this->browse(function (Browser $browser) {
        // Testing forms
        $browser
            ->loginAs(App\User::find(1))
            ->visit('dashboard/user/create')
            ->fillHidden('#myHiddenField', 'new value');
    });
}
```

Fuente: [https://dev.to/barmmie_/5-useful-tricks-for-laravel-dusk-44cm](https://dev.to/barmmie_/5-useful-tricks-for-laravel-dusk-44cm){.link-out}

3. selectOption

Nos permite seleccionar cualquier opción de un campo de formulario select:

```php
// Seleccionamos la tercera opción. La primera será la 0.
public function test_select_field()
{
    $this->browse(function (Browser $browser) {
        // Testing forms
        $browser
            ->loginAs(App\User::find(1))
            ->visit('dashboard/user/create')
            ->selectOption('#mySelect', 2);
    });
}
```

Basado en: [https://medium.com/@icheko/laravel-dusk-browser-macro-61769e3dba5f](https://medium.com/@icheko/laravel-dusk-browser-macro-61769e3dba5f){.link-out}

4. selectRadioOption

Sirve para seleccionar un campo de formulario tipo: radio, a partir del selector del campo:

```php
public function test_radio_field()
{
    $this->browse(function (Browser $browser) {
        // Testing forms
        $browser
            ->loginAs(App\User::find(1))
            ->visit('dashboard/user/create')
            ->selectRadioOption('#myRadio');
    });
}
```

Fuente: [https://www.5balloons.info/using-browser-macros-in-laravel-dusk/](https://www.5balloons.info/using-browser-macros-in-laravel-dusk/){.link-out}

5. waitForReload

Permite esperar a que la página actual se recargue, por ejemplo, después de una llamada `Ajax`:

```php
public function test_page_reload()
{
    $this->browse(function (Browser $browser) {
        // Testing forms
        $browser
            ->click('button')
            ->waitForReload()
            ->assertSee('Something on new page');
    });
}
```

Fuente: [https://gist.github.com/calebporzio/eb5cae2064a96e4fbf8f2ecf01626305](https://gist.github.com/calebporzio/eb5cae2064a96e4fbf8f2ecf01626305){.link-out}
