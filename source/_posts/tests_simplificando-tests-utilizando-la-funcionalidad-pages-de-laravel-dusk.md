---
extends: _layouts.post
section: content
title: Usando funcionalidad Pages de Laravel Dusk
date: 2020-11-08
description: Laravel Dusk permite la creación de clases tipo Page, para simplificar y automatizar procesos durante la realización de test de navegador
categories: [laravel, php, tests]
---

Últimamente estoy haciendo muchos `tests` con `Laravel Dusk`, y he encontrado en la opción de generar `Pages` una forma de simplificarlos, y además, de una forma muy considerable.

La idea es no repetir código y crear métodos personalizados. En mi caso sigo una estructura de código claramente basada en `CRUD`, es decir: Crear, Editar, Eliminar,... por lo que todo mi código es (en general) muy parecido, y por tanto, las pruebas de `test` suelen ser muy similares. Como siempre, hay excepciones, pero una parte importante del código funciona siguiendo este patrón.

La idea ahora, es la de sacarle partido a esta situación para simplificar los `tests`. Para ello lo que he hecho ha sido crear una página para cada acción del sistema `CRUD`, por ejemplo, veamos el caso de `CREAR`. 

Lo primero es crear esta página con `artisan`:

```bash
php artisan dusk:page Create
```

Ahora empecemos a simplificar código:

```php 
<?php

namespace Tests\Browser\Pages;

use Laravel\Dusk\Browser;

class Create extends Page
{
    protected $section;

    /**
     * Create a new Create instance.
     */
    public function __construct(string $section)
    {
        $this->section = $section;
    }

    /**
     * Get the URL for the page.
     *
     * @return string
     */
    public function url()
    {
        return route('dashboard.' . $this->section . '.create');
    }

    /**
     * Assert that the browser is on the page.
     *
     * @param  Browser  $browser
     * @return void
     */
    public function assert(Browser $browser)
    {
        $browser->assertUrlIs($this->url());
    }

    // /**
    //  * Get the element shortcuts for the page.
    //  *
    //  * @return array
    //  */
    // public function elements()
    // {
    //     return [
    //         '@element' => '#selector',
    //     ];
    // }

    /**
     * Select Date
     */
    public function selectDate(Browser $browser, string $selector, int $day, int $month, int $year): void
    {
        $browser
            ->keys($selector, $day, $month, $year)
            ->pause(200)
            ->assertInputValue($selector, sprintf('%s-%s-%s', $year, $month, $day));
    }

    /**
     * Select Field
     *
     * @param mixed $value
     */
    public function selectField(Browser $browser, string $selector, $value): void
    {
        $browser
            ->select($selector, $value)
            ->assertValue($selector . '-hidden', $value);
    }

    /**
     * Submit
     */
    public function buttonSubmit(Browser $browser): void
    {
        $browser
            ->assertMissing('.message-alert-green')
            ->click('@form-button-create')
            ->waitFor('.message-alert-green')
            ->assertUrlIs(route('dashboard.' . $this->section . '.index'));
    }
}

```

En este caso he añadido tres métodos: `selectDate()`, `selectField` y `buttonSubmit()`. Por supuesto, cuanto más répitas el código a lo largo de tu `test` más optimizado quedará todo. 

`selectDate()` es una forma de simplificar el proceso de añadir fechas a campos `input` con el `type` en `date`, lo cual es un poco engorroso y con este método se simplifica.

El segundo método `selectField()`, selecciona un campo `select` y verifica que al hacerlo se dispare un evento, el cual añada el valor seleccionado del campo a un segundo campo oculto.

El tercero `buttonSubmit()` envía el formulario al Controlador y verifica que se ha redireccionado (una vez se ha añadido el elemento a la base de datos) y que aparece el mensaje de que se ha realizado la operación con éxito.

Ahora veamos como transladar esto a un `test`:

```php 
// dusk --filter=test_can_create_a_post
public function test_can_create_a_post()
{
    $this->browse(function ($browser) {
        $browser
            ->loginAs($this->user)
            ->visit(new Create('posts'))
            ->selectDate('@posts-date', 10, 10, 2019)
            ->selectField('@posts-mode', 1)
            ->buttonSubmit();
});
```

Y podemos reutilizar este código en otros `tests`:

```php 
// dusk --filter=test_can_create_a_profile
public function test_can_create_a_profile()
{
    $this->browse(function ($browser) {
        $browser
            ->loginAs($this->user)
            ->visit(new Create('profiles'))
            ->type('@name', 'Damián Aguilar')
            ->type('@email', 'email@email.com')
            ->selectDate('@birthday', 10, 10, 2019)
            ->selectField('@role', 1)
            ->buttonSubmit();
});
```

Si en vez de utilizar todo esto escribiéramos el `test` directamente, quedaría así:

```php 
// dusk --filter=test_can_create_a_post
public function test_can_create_a_post()
{
    $this->browse(function ($browser) {
        $browser
            ->loginAs($this->user)
            ->visit(route('dashboard.posts.create'))
            ->keys('@posts-date', 10, 10, 2019)
            ->pause(200)
            ->assertInputValue('@posts-date', sprintf('%s-%s-%s', $year, $month, $day))
            ->select('@posts-mode', 1)
            ->click('@form-button-create')
            ->waitFor('.message-alert-green')
            ->assertUrlIs(route('dashboard.posts.index'));
});
```

Cuando más complicado es el `test` más beneficios se obtienen de esta técnica. Otra técnica que utilizo para reutilizar aún más el código, es extraer todo los métodos repetidos en todas las acciones `CRUD` que he creado a un `trait`. Así solo tengo que ir llamando al `trait` si el `test` lo necesita.

Por ejemplo, el método `selectDate()` se puede utilizar en las páginas `Create` y `Update`, por lo que extraerlo a un `trait` va a evitar que repitamos código. 
