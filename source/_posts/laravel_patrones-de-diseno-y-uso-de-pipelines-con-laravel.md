---
extends: _layouts.post
section: content
title: Patrones de diseño y uso de Pipelines con Laravel
date: 2019-01-03
description: Utilización del patrón de diseño Pipelines, incluido en Laravel por defecto.
categories: [laravel, php]
---

Las *Pipelines* de [Laravel](https://laravel.com){.link-out}, nos van a permitir enviar un objeto a través de una serie de clases de forma sencilla y ordenada, simplificando considerablemente nuestro código.

Realmente, es un *patrón de diseño* utilizado por **Laravel** de forma interna, pero que no vas a encontrar en su documentación. En cualquier caso, lo puedes implementar en tu proyecto sin ningún problema.

Personalmente, suelo utilizarlo bastante para hacer un *refactoring* del código, consiguiendo simplificarlo considerablemente, y sobre todo, ordenándolo, que últimamente, se está conviertiendo en una obsesión...

La mejor forma de comprender su funcionamiento, y cómo puede ayudarnos a simplificar nuestro código, es con un ejemplo. Imaginemos la siguiente clase:

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

Estoy seguro que te has encontrado con clases con muchos más condicionales, y que al final, se convierten en una interminable lista de condiciones... Usemos las *Pipelines* para simplificarlo. Nuestra clase principal, quedará así:

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

Lo que hemos hecho, ha sido enviar el valor `$level`, a través de una serie de clases, que cada una, va a realizar una única función. Veamos, a modo de ejemplo, como quedaría la primera clase:

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

El método, es obligatorio que se llame `handle()`, y debe de incluir una `Closure`. 

Lo que hacemos es devolver el resultado si se cumple la condición, y si no, enviamos la variable a la clase siguiente.

Generando una estructura de directorios, similar a esta:

```bash
./Roles.php 
./Filters/Invitado.php
./Filters/Usuario.php
./Filters/Editor.php
./Filters/Administrador.php
```
Un ejemplo de esta implementación, pero bastante más compleja, lo podeis encontrar aquí:

https://github.com/daguilarm/belich/blob/master/src/Fields/Resolves/Handler/Index/Values.php
