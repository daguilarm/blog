---
extends: _layouts.post
section: content
title: Trucos, consejos y sitaciones extrañas con Laravel Dusk
date: 2020-10-25
description: Realizando test para Laravel Dusk me he encontrado consituaciones muy extrañas, y he aprendido algunos trucos.
categories: [laravel, php, tests]
---

Llevo varios días liado con las pruebas de una plantilla para panel de administración realizada con `Laravel`, `Livewire` y `AlpineJS`, y la verdad es que `Laravel Dusk` se ha convertido en la base de las pruebas, junto con algunos test unitarios y algunos test con `Livewire`, pero básicamente están basadas en `Laravel Dusk`.

Me he puesto a probar algunos campos de formulario tipo `date` y me he encontrado con la siguiente situación:

```php
$browser
    ->loginAs($this->user)
    ->visit(route('dashboard.section.index'))
    // Verifico que existe el formulario
    ->assertPresent('.form')
    // Escribo la fecha que quiero buscar
    ->type('@form-date', '10/10/2020')
    ->click('@form-button')
    // Verifico que se ve la fecha en la pantalla
    ->assertSee('10/10/2020')
```

Y como era de esperar no ha funcionado... Buscando en internet he encontrado esto:

+ [https://medium.com/@stefanledin/testing-a-date-input-field-with-laravel-dusk-d6ae2a13d207](https://medium.com/@stefanledin/testing-a-date-input-field-with-laravel-dusk-d6ae2a13d207){.link-out}

Así que he cambiado mi test por:

```php
$browser
    ->loginAs($this->user)
    ->visit(route('dashboard.section.index'))
    // Verifico que existe el formulario
    ->assertPresent('.form')
    // Escribo la fecha que quiero buscar
    ->keys('#birthday', '10', '{tab}', '10', '2020')
    ->click('@form-button')
    // Verifico que se ve la fecha en la pantalla
    ->assertSee('10/10/2020')
```

Y sigue sin funcionar, y la fecha no se escribe correctamente debido al tabulador. Segundo intento:

```php
$browser
    ->loginAs($this->user)
    ->visit(route('dashboard.section.index'))
    // Verifico que existe el formulario
    ->assertPresent('.form')
    // Escribo la fecha que quiero buscar
    ->keys('#birthday', '10', '10', '2020')
    ->click('@form-button')
    // Verifico que se ve la fecha en la pantalla
    ->assertSee('10/10/2020')
```

Sigue sin funcionar, pero ahora la fecha si se muestra correctamente. Tercer intento y definitivo:

```php
$browser
    ->loginAs($this->user)
    ->visit(route('dashboard.section.index'))
    // Verifico que existe el formulario
    ->assertPresent('.form')
    // Escribo la fecha que quiero buscar
    ->keys('#birthday', '10', '10', '2020')
    ->pause(200)
    ->click('@form-button')
    // Verifico que se ve la fecha en la pantalla
    ->assertSee('10/10/2020')
```

Haciendo pruebas, parece que añadiendo una pausa de `200` es el menor espacio de tiempo para que funcione. Cosas curiosas que pasan.

Otro truco que he empezado a utilizar por todas partes en mis pruebas, es la de la utilización de los elementos `wait`, sobre todo estos cuatro:

- waitFor()
- waitUntilMissing()
- waitForText()
- waitUntilMissingText()

Principalmente porque al añadir efectos de transición y eventos mediante `Livewire` y `AlpineJS`, la utilización de `pause()` puede hacer que nuestras pruebas sean bastante más lentas (o tarden un tiempo innecesario). 

Por ejemplo, esta es una prueba real de un proyecto anterior (básicamente es una plataforma para la gestión agrícola):

```php
$browser
    ->loginAs($this->farmer)
    ->visit(route('dashboard.fertilizations.index'))
    ->assertUrlIs(route('dashboard.fertilizations.index'))
    ->assertSelectHasOptions('@search-filter-worker', [1, 2])
    ->assertSelectMissingOption('@search-filter-worker', 3)
    ->click('@table-filter-button')
    // Esperamos al elemento
    ->waitFor('@search-filter-worker')
    ->select('@search-filter-worker', 1)
    // Esperamos a que se cargue la información - es un indicador de loading...
    ->waitUntilMissing('.pulse');
```

El código original era este:

```php
$browser
    ->loginAs($this->farmer)
    ->visit(route('dashboard.fertilizations.index'))
    ->assertUrlIs(route('dashboard.fertilizations.index'))
    ->assertSelectHasOptions('@search-filter-worker', [1, 2])
    ->assertSelectMissingOption('@search-filter-worker', 3)
    ->click('@table-filter-button')
    // Esperamos al elemento
    ->pause(500)
    ->select('@search-filter-worker', 1)
    // Esperamos a que se cargue la información - es un indicador de loading...
    ->pause(500);
```

El primer código es más rápido. En cuanto a ganar velocidad en las pruebas con `Laravel Dusk`, un truco que me funciona es el de utilizar multiples instancias de `$browser` a la vez. Por ejemplo:

```php
$this->browse(function ($browser) {
    $browser
        ->loginAs($this->farmer)
        ->visit(route('dashboard.section1.index'))
        ->assertUrlIs(route('dashboard.section1.index'));
});

$this->browse(function ($browser) {
    $browser
        ->loginAs($this->farmer)
        ->visit(route('dashboard.section2.index'))
        ->assertUrlIs(route('dashboard.section1.index'));
});
```

Si quermeos que la prueba sea más rápida, debemos hacerla así:

```php
$this->browse(function ($browser1, $browser2) {
    $browser1
        ->loginAs($this->farmer)
        ->visit(route('dashboard.section1.index'))
        ->assertUrlIs(route('dashboard.section1.index'));
    $browser2
        ->loginAs($this->farmer)
        ->visit(route('dashboard.section2.index'))
        ->assertUrlIs(route('dashboard.section1.index'));
});
```

El incremento de velocidad es considerable, o al menos, a mi me lo está pareciendo...
