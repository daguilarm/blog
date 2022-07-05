---
extends: _layouts.post
section: content
title: Patrones de diseño y uso de Pipelines con Laravel
date: 2020-01-03
description: Utilización del patrón de diseño Pipelines, incluido en Laravel por defecto. Es un patrón bastante desconocido y que puede ser muy útil para simplicar código y refactorizarlo.
categories: [laravel, php, frameworks]
---

Las *Pipelines* de [Laravel](https://laravel.com){.link-out}, nos van a permitir enviar un objeto a través de una serie de clases de forma sencilla y ordenada, simplificando considerablemente el código.

Realmente, es un *patrón de diseño* utilizado por **Laravel** de forma interna, pero que no vas a encontrar en su documentación, y la verdad es que no se por qué... En cualquier caso, lo puedes implementar en tu proyecto sin ningún problema.

Personalmente, suelo utilizarlo bastante para hacer un *refactoring* del código, consiguiendo simplificarlo considerablemente, y sobre todo, ordenándolo, algo que últimamente se está conviertiendo en una obsesión...

La mejor forma de comprender el funcionamiento de las *Pipelines*, y cómo esta puede ayudarnos a simplificar nuestro código, es con un ejemplo. Imaginemos la siguiente clase:

```php
<?php 

namespace MyNamespace;

final class Roles
{
    public function handle(int $level = 0)
    {
        if ($level === 0) {
            return 'eres un invitado';
        }

        if ($level === 1) {
            return 'eres un usuario';
        }

        if ($level === 2) {
            return 'eres un editor';
        }

        if ($level === 3) {
            return 'eres un administrador';
        }
    }
}
```

Estoy seguro que te has encontrado con clases con muchos más condicionales, y que al final, se convierten en una interminable lista de condiciones... Usemos las *Pipelines* para simplificarlo. La estructura básica es la siguiente: 

```php
$pipeline = app(Pipeline::class)
    ->send($level)
    ->through([
        \MyNamespace\Invitado::class,
        \MyNamespace\Usuario::class,
        \MyNamespace\Editor::class,
        \MyNamespace\Administrador::class,
    ])
    ->then(function ($content) {
        return 'Tu nivel de acceso es: ' . $level;
    });
```

1. Instanciamos a la clase *Pipeline*: `Illuminate\Pipeline\Pipeline`.
2. Definimos la variable que queremos enviar a través de la *Pipeline*, y que por tanto, será accesible a todas las clases de forma automática, a través del método `send()`.
3. El método `through()`, nos permite definir un *array* con toda la lista de clases que queremos que se ejecuten.
4. Finalmente, ejecutamos una acción final.

Disponemos de otros métodos, por ejemplo, si al final simplemente queremos devolver el valor de `$level`, una vez ha pasado por todos los filtros, podemos usar el método: `thenReturn()` en vez de `then()`, y nuestra clase principal, quedará así:

```php
<?php 

namespace MyNamespace;

use Illuminate\Pipeline\Pipeline;

final class Roles
{
    public function handle(int $level = 0)
    {
        // Add filters to the pipeline
        return app(Pipeline::class)
            ->send($level)
            ->through([
                \MyNamespace\Invitado::class,
                \MyNamespace\Usuario::class,
                \MyNamespace\Editor::class,
                \MyNamespace\Administrador::class,
            ])
            ->thenReturn();
    }
}
```

Lo que hemos hecho, ha sido enviar el valor `$level` a través de una serie de clases o filtros, realizando cada una de ellas, una función específica. Veamos, a modo de ejemplo, como quedaría la primera de estas clases:

```php
<?php 

namespace MyNamespace\Filters;

use Closure;

final class Invitado
{
    public function handle($level, Closure $next)
    {
        if ($level === 0) {
            return $next('eres un invitado');
        }

        return $next($level);
    }
}
```

Si os fijais, tiene la estructura clásica de un *middleware* de **Laravel**. Y por tanto, el método: `handle()`, es obligatorio y debe de incluir una `Closure`. Lo que hacemos con esto, es devolver el resultado si se cumple la condición, y si no, enviamos la variable a la clase siguiente.

Si por cualquier motivo queremos cambiar el método `handle()` por otro que nos interese más, disponemos del método `via('myNewMethod')` para hacerlo:

```php
// Add filters to the pipeline
return app(Pipeline::class)
    ->send($level)
    ->via('nuevoMetodo')
    ->through([
        \MyNamespace\Invitado::class,
        \MyNamespace\Usuario::class,
        \MyNamespace\Editor::class,
        \MyNamespace\Administrador::class,
    ])
    ->thenReturn();
```

En el ejemplo anterior, hemos generando una estructura de directorios, similar a esta:

```bash
./Roles.php 
./Filters/Invitado.php
./Filters/Usuario.php
./Filters/Editor.php
./Filters/Administrador.php
```

Toda la información y los métodos disponibles se encuentran aquí:

[https://laravel.com/api/6.x/Illuminate/Pipeline/Pipeline.html](https://laravel.com/api/6.x/Illuminate/Pipeline/Pipeline.html){.link-out}
