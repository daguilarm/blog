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

El mismo código, pero más sencillo. Veamos un ejemplo más compejo:

```php
function users($usuarios, $edad) {
    if($usuarios > 10 && $edad > 18) {
        return 'Son muchos usuarios.';
    } elseif($usuarios > 10 && $edad <= 18) {
        return 'Son muchos usuarios. Son menores de edad';
    } elseif($usuarios < 10 && $edad <= 18) {
        return 'Son pocos usuarios. Son menores de edad';
    } else {
        return 'Son pocos usuarios.';
    }
}
```

A simple vista, podemos usar la técnica anterior para optimizar un poco esto:

```php
function users($usuarios, $edad) {
    if($usuarios > 10 && $edad > 18) {
        return 'Son muchos usuarios.';
    } 

    if($usuarios > 10 && $edad <= 18) {
        return 'Son muchos usuarios. Son menores de edad.';
    } 

    if($usuarios < 10 && $edad <= 18) {
        return 'Son pocos usuarios. Son menores de edad.';
    } 

    return 'Son pocos usuarios.';
}
```

Eliminamos los `elseif` y los `else`, que desde mi punto de vista, solo complican la legibilidad del código. Lo siguiente que podemos hacer es dividir el código en más funciones.

```php
function usersAndAge($usuarios, $edad) {
    sprintf('%s %s', users($usuarios), age($edad));
}

function users($usuarios) {
    if($usuarios > 10) {
        return 'Son muchos usuarios.';
    } 

    return 'Son pocos usuarios.';
}

function age($edad) {
    if($edad > 18) {
        return 'Son menores de edad.';
    } 

    return 'Son menores de edad.';
}
```

La idea es simplificar el código en unidades más pequeñas y con una sola responsabilidad. Así conseguiremos un código más sencillo, entendible y práctico. 

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

Un ejemplo más complejo:

```php
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
```

Es un `middleware` para minimizar código `HTML`. Después de pensarlo un poco, ha quedado así:


```php
/**
 * Handle an incoming request.
 */
public function handle(Request $request, Closure $next): Illuminate\Http\Request
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
    if ($this->actionExcluded()) {
        return $response;
    }

    //Filter by url path
    if ($this->urlPath()) {
        return $response;
    }

    //Minify
    return $response->setContent(
        $this->html($response->getContent())
    );
}

private function actionExcluded() {
    return in_array($this->action(), $this->exceptedActions());
}

private function urlPath() {
    $request = trim($request->path(), '/');

    return in_array($request, config('option.except.paths'));
}
```

El objetivo aquí era que el código fuese más legible, y por ello, me ha dado igual que aumentasen las líneas de código. Personalmente, me parece una mejora. 

Al final lo que busco en el código es que cuando vuelva a él dentro de unos meses, sea capaz de seguirlo sin problemas. Un saludo.
