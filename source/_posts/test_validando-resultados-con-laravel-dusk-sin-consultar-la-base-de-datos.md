---
extends: _layouts.post
section: content
title: Verificar resultados con Laravel Dusk utilizando los resultados que se muestran en el navegador
date: 2021-05-17
description: Verificar resultados con Laravel Dusk utilizando técnicas basadas en los resultados que se muestran en el navegador
categories: [laravel, php, tests]
cover_image: laravel-dusk-html-count.jpg
---

**Laravel dusk** nos ofrece la opción de verificar si los cambios se han realizado en la base de datos después de realizar el test. El primer paso, sería realizar el test y con ello, los cambios en la base de datos, y puesteriormente, comprobar que los nuevos resultados (o la ausencia de ellos), se encuentran en la base de datos:

```php 
$this->assertDatabaseHas('users', [
    'email' => 'email@example.com',
    ...
]);
```

Esta sería una forma de hacerlo, pero me parece que es mejor hacerlo en base a los resultados mostrados en pantalla. Por ejemplo, podemos buscar directamente si el email se muestra en pantalla, o por ejemplo, si mostramos los resultados de la base de datos mediante una tabla, lo que podríamos comprobar es si el resultado se muestra en la fila adecuada, es decir, podemos buscar en la fila X a ver si encontramos el email Y. En este caso, vamos a buscar en la fila **3** el email **email@example.com**.

```php 
$browser->with('.table', function ($table) {
    $table->assertSeeIn(
        'table > tbody > tr:nth-child(3)', 
        'email@example.com'
    );
});
```

Otra situación que se nos puede presentar es verificar el número total de resultados que se obtienen en el navegador. Por ejemplo, **si hacemos una busqueda y esperamos 5 resultados, lo que podemos hacer es contar las filas de la tabla, y ver que efectivamente son 5 filas**. Podemos hacerlo de la siguiente forma:

```php 
$totalResults = $browser
    ->driver
    ->findElements(WebDriverBy::cssSelector('table > tbody > tr'));

$this->assertEquals($totalResults, 5);
```

Básicamente utilizo estas técnicas cuando tengo que probar una aplicación basada en `Datatables`, y necesito testear las búsquedas, filtros, paginación, etc...
