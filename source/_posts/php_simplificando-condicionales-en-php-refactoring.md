---
extends: _layouts.post
section: content
title: Simplificando condicionales con PHP - Refactoring conditionals
date: 2021-03-24
description: Refactoring condicionales con PHP. Simplificando condicionales y bucles con PHP
categories: [php]
---

Es fácil dejarse llevar por un grupo de condicionales anidados y complicar el código muy facilmente, convirtiéndolo en algo complejo y dificil de seguir.

La idea, no es solo simplificarlo, sino también conseguir que sea fácil de seguir con facilidad, por lo tanto, no se trata sólo de reducir el código a la mínima expresión, también hay que conseguir que el código sea simple de entender, aunque esto implique no reducirlo al máximo.

Desde mi punto de vista, el código primero tiene que ser muy sencillo de interpretar, y después, conseguir reducirlo a la mínima expresión.

Veamos un ejemplo de un código que podemos encontrarnos fácilmente:

```php
function users($usuarios) {
    if($usuarios > 10) {
        return 'Son muchos usuarios';
    } else {
        return 'Son pocos usuarios';
    }
}
```

Este código se entiende con facilidad, pero se puede simplificar más, no hay necesidad del `else`:

```php
function users($usuarios) {
    if($usuarios > 10) {
        return 'Son muchos usuarios';
    } 

    return 'Son pocos usuarios';
}
```

El mismo código, pero más complejo. Veamos el ejemplo:

```php
function users($usuarios, $edad) {
    if($usuarios > 10 && $edad >= 18) {
        return 'Son muchos usuarios. Son mayores de edad.';
    } elseif($usuarios > 10 && $edad < 18) {
        return 'Son muchos usuarios. Son menores de edad';
    } elseif($usuarios < 10 && $edad >= 18) {
        return 'Son pocos usuarios. Son mayores de edad';
    } else {
        return 'Son pocos usuarios.';
    }
}
```

A simple vista, podemos usar la técnica anterior para optimizar un poco esto:

```php
function users($usuarios, $edad) {
    if($usuarios >= 10 && $edad >= 18) {
        return 'Son muchos usuarios. Son mayores de edad.';
    } 

    if($usuarios >= 10 && $edad < 18) {
        return 'Son muchos usuarios. Son menores de edad.';
    } 

    if($usuarios < 10 && $edad >= 18) {
        return 'Son pocos usuarios. Son mayores de edad.';
    } 

    return 'Son pocos usuarios.';
}
```

Eliminamos los `elseif` y los `else` del código, los cuales, desde mi punto de vista solo complican la legibilidad del código. Lo siguiente que podemos hacer es dividir el código en más funciones y **darle a estas funciones un nombre descriptivo, el cual indique que hace la función exactamente**. Esto último es algo importante, porque luego perdemos demasiado tiempo investigando que hace cada función.

```php
function usersAndAge($usuarios, $edad) {
    sprintf('%s %s', totalUsers($usuarios), isUserAdult($edad));
}

function totalUsers($usuarios) {
    if($usuarios >= 10) {
        return 'Son muchos usuarios.';
    } 

    return 'Son pocos usuarios.';
}

function isUserAdult($edad) {
    if($edad >= 18) {
        return 'Son mayores de edad.';
    } 

    return 'Son menores de edad.';
}
```

La idea es simplificar el código en unidades más pequeñas y con una sola responsabilidad, así cada función hace solo una cosa. Con esto conseguiremos un código más sencillo, entendible y práctico. 

El siguiente ejemplo, es el resultado de plantear condiciones sin pararse a pensar un minuto:

```php
public function example1()  
{
    if ($condition1) {
        $response = 'response 1';
    } else {
        if ($condition2) {
            $response = 'response 2';
        } else {
            $response = 'response 3';
        }
    }

    return $response;
}
```

Si lo pensamos un poco, podría quedarse así:

```php
public function example1()  
{
    if ($condition1) {
        return 'response 1';
    } 

    if ($condition2) {
        return 'response 2';
    } 

   return 'response 3';
}
```

**A veces, el problema del código es que no se ha pensado lo suficiente, y termina por ser redundante**.

Un ejemplo más complejo, un `middleware` para **Laravel**:

```php
<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class MinifyHtml
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next)
    {
        /** @var Response $response */
        $response = $next($request);

        if (config('option.enable') && $this->isHtml($response)) {
            //Filter by exclusionary action
            if (in_array($this->action(), $this->exceptedActions())) {
                return $response;
            }
            //Filter by url path
            if (in_array(trim($request->path(), '/'), config('option.except.paths'))) {
                return $response;
            }

            //Minify
            $response->setContent($this->html($response->getContent()));
        }

        return $response;
    }
}
```

Es un `middleware` para minimizar el código `HTML`. Después de pensarlo un poco, ha quedado así:


```php
<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class MinifyHtml
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next): Request
    {
        /** @var Response $response */
        $response = $next($request);

        // If the minify is disabled
        if (! config('option.enable')) {
            return $response;
        }

        // If the headers are incorrents
        if (! $this->isHtml($response)) {
            return $response;
        }

        // If the current action is excluded
        if ($this->filterByActionExcluded()) {
            return $response;
        }

        //Filter by url path
        if ($this->filterByUrl()) {
            return $response;
        }

        //Minify
        return $response->setContent(
            $this->html($response->getContent())
        );
    }

    private function filterByActionExcluded() 
    {
        return in_array(
            $this->action(), 
            $this->exceptedActions()
        );
    }

    private function filterByUrl(Request $request) 
    {
        return in_array(
            $this->requestUrl($request), 
            config('option.except.paths')
        );
    }

    private function requestUrl(Request $request) 
    {
        return trim($request->path(), '/');
    }
}
```

El objetivo aquí era que el código fuese más legible, y por ello, no me ha importado demasiado que aumentasen las líneas de código. Personalmente, me parece una mejora, ya que se entiende muy facilmente, y se han evitado condicionales complejos y todo parece más fluido y simplificado. 

Al final, esto es lo que busco en el código que genero. Básicamente lo que quiero es que cuando vuelva a este código dentro de unos meses, sea capaz de seguirlo sin problemas, y sin tener que perder demasiado tiempo en descrifrar la lógica del código. 

Para profundizar más en el tema, aquí tienes un vídeo (en inglés), de [Freek Van der Herten](https://freek.dev){.link-out} (todo un referente en la comunidad **Laravel** y **PHP**) sobre como mejorar el diseño de condicionales complejos.

[How to refactor complex if statements](https://freek.dev/1578-how-to-refactor-complex-if-statements){.link-out}

También os dejo un artículo que escribí hace tiempo, en el que explico como usar las `Pipelines` de **Laravel** para simplificar los condicionales utilizando este patrón de diseño.

[https://daguilar.dev/blog/laravel_patrones-de-diseno-y-uso-de-pipelines-con-laravel/](https://daguilar.dev/blog/laravel_patrones-de-diseno-y-uso-de-pipelines-con-laravel/)

Un saludo y espero que sirva de algo.
