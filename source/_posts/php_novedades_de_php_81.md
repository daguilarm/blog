---
extends: _layouts.post
section: content
title: Novedades de PHP 8.1
date: 2022-06-11
update: 2022-07-03
description: Actualizando a PHP 8.1. Con todas las novedades y mejoras del mejor lenguaje de programación del momento.
categories: [php]
---

Soy consciente de que llego un poco tarde, sobre todo porque en pocos meses sale la versión 8.2, pero más vale tarde que nunca. 

1) Lo primero de todo, se han producido mejoras en *opchache* que han generado una **ligera mejora en el rendimiento**, respecto a la versión de PHP 7.4.

2) **Una de las funcionalidades más esperadas eran las de `Emumns`, que `frameworks` como **Laravel** ya han integrado en su última versión (la 9). Veamos un ejemplo:

```php 
enum Status {
  case Pending;
  case Active;
  case Archived;
}

function cambioDeEstado(Status $status): void {
    ...
}
```

3) El tipo *never* para los métodos. Nos permite definir un retorno tipo `void`, pero cuando queremos que el programa no continue más. Por ejemplo, puede ser útil para las redirecciones o para métodos que interrumpan la ejecuación:

```php
function stop(): never
{    
    // Detenemos los procesos

    exit;
}
```

4) **Fibers**. Consiste en gestionar los threads o hilos en PHP. Creo que es algo que no voy a utilizar mucho, por lo que he leido, algunos frameworks o sistemas complejos son los principales beneficiarios de esta funcionalidad.

5) **Propiedad readonly**. Algo que he utilizado mucho con **TypeSCript**, y que **PHP** aún no había implementado. Básicamente, inicializas una propiedad, y una vez hecho esta, su valor no puede cambiar:

```php 
class MyClass {
    public readonly string $attribute;
 
    public function __construct(string $attribute) {
        $this->attribute = $attribute;
    }
}
```

6) Lo mismo con las **constantes finales**:

```php 
class MyClass1 {
    final public const VALUE = 'hello';
}

// Dará error... no se puede cambiar
class MyClass2 extends MyClass1 {
    final public const VALUE = 'hello world';
}
```

7) **Mejora en la unión de arrays**, facilitando las operaciones entre `arrays`. Desde ahora, el funcionamiento del "*array unpacking*" es parecido al de `array_merge()`:

```php 
$array_1 = ['elemento 1', 'elemento 2'];
$array_2 = ['elemento 3', 'elemento 4'];
```

Lo normal para unir esto arrays, y añadirle otro más, sería usar `array_merge()`:

```php 
$array_3 = array_merge($array_1, $array_2, ['elemento 5']);
var_dump($array_3)

// Devolvería 
// ['elemento 1', 'elemento 2', 'elemento 3', 'elemento 4', 'elemento 5']
```

Ahora, podemos hacerlo directamente:

```php 
$array_4 = [...$array_1, ...$array_2, ...['elemento 5']];
var_dump($array_4)

// Devolvería 
// ['elemento 1', 'elemento 2', 'elemento 3', 'elemento 4', 'elemento 5']
```

**Desde PHP 7.4 está implmentada esta funcionalidad**, pero solo funcionaba con números.

8) **Nuevos algoritmos de Hashing**. Desde ahora se da soporte para `xxHash` y `MurMurHash3`. Parecen ser algoritmos muchos más rápidos y seguros...

9) **Nueva función `array_is_list()`**. Sirve para determinar si un array es una lista perfecta, incluyendo claves y valores. Es decir, si usamos sólo claves, determinará si la sucesión es correcta. Veamos algunos ejemplos:

```php 
array_is_list([1, 2, 3]); // Es correcto, se sigue el orden correlativo, y no importa que no empiece por 0, ya que son valores.
array_is_list([1 => 1, 2 => 2, 3 => 3]); // En este caso daría FALSE, porque la clave debe empezar en 0, y no en 1.
array_is_list([0 => 1, 1 => 2, 2 => 'hello']); // Es correcto, las claves son correlativas y empiezan en 0, los valores da igual... son valores.
array_is_list(['a', 1 => 'b', 'c']); // Solo hay una clave, en segunda posición y con el valor 1, que es correcto, por lo que todo correcto.
```

Existen muchas más novedades que pueden consultarlas aquí:

- [Nuevo en php](https://www.php.net/releases/8.1/es.php){.link-out}