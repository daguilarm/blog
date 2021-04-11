---
extends: _layouts.post
section: content
title: Simplificando condicionales con PHP (parte II) - Refactoring conditionals
date: 2021-04-11
description: Refactoring condicionales con PHP. Simplificando condicionales y bucles con PHP
categories: [php]
---

    En este artículo, se van a ver diversas técnicas de reducción de condicionales y simplificación de código, para versiones de **php8**.

Este artículo es continuación del ya publicado [Simplificando condicionales con PHP (parte I)](https://daguilar.dev/blog/php_simplificando-condicionales-en-php-refactoring/). Aquí veremos otras técnicas de simplificación de condicionales, utilizando **php** en su versión 8.

Empecemos con la nueva función `match()`, que nos permite simplificar los `switch` de forma muy importante. Veamos un ejemplo de como se hacía antes:

```php
public function showOn(string $value): self
{
    switch ($value) {
        case 'sm':
            $show = 'visible';
            break;
        case 'md':
            $show = 'hidden md:visible';
            break;
        case 'lg':
            $show = 'hidden lg:visible';
            break;
        case 'xl':
            $show = 'hidden xl:visible';
            break;
    }

    $this->show = $show;

    return $this;
}
```

La nueva función `match()` nos va a permitir añadir el resultado a una variable de forma directa:

```php
public function showOn(string $value): self
{
    $this->show = match ($value) {
        'sm' => 'visible',
        'md' => 'hidden md:visible',
        'lg' => 'hidden lg:visible',
        'xl' => 'hidden xl:visible',
    };

    return $this;
}
```

Y por supuesto que podemos seguir añadiendo un valor por defecto:

```php
public function showOn(string $value): self
{
    $this->show = match ($value) {
        'sm' => 'visible',
        default => 'hidden',
    };

    return $this;
}
```

Hasta ahora, era poco amigo de la función `switch()` y la verdad es que la he utilizado muy poco, principalmente por lo poco amigable que era, y la cantidad de basura repetitiva que había que utilizar: `case`, `break`,... ahora la cosa ha cambiado, la nueva sintaxis de `match()` me ha convencido.

La otra ventaja para lidiar con condicionales que podemos encontrar en `php` 8, la encontramos en el nuevo operador **nullsafe**. El ejemplo que pone la página oficial de [php](https://www.php.net/releases/8.0/es.php){.link-out}, me parece de lo más descriptivo:

```php
$country =  null;

if ($session !== null) {
  $user = $session->user;

  if ($user !== null) {
    $address = $user->getAddress();
 
    if ($address !== null) {
      $country = $address->country;
    }
  }
}
```

Con el nuevo operador se queda en:

```php
$country = $session?->user?->getAddress()?->country;
```

Parece increible... si en cualquiera de las conexiones se rompe la cadena, el sistema automáticamente devolverá `NULL` y se detiene el proceso. Es un poco similar a lo que en **Laravel** podemos hacer con la función `optional()`:

```php
$address = optional(optional($user)->address)->street;
```

Un saludo y espero que sea de utilidad.
