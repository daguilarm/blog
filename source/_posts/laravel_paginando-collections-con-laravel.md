---
extends: _layouts.post
section: content
title: Paginando Colecciones con Laravel y optimizando consultas SQL
date: 2022-08-03
description: Optimizando consultas SQL a la base de datos, utizando para ello paginación de Collections. A partir de una Colección de Laravel vamos a realizar una paginación.
categories: [php, laravel]
---

Estos días me he encontrado con un caso real, en el que hacía dos consultas a la base de datos cuando realmente sólo quería hacer una. A veces lo que uno quiere y lo que puede conseguir no son compatibles, pero en este caso, si que ha sido posible.

Planteo el problema. Imagina que tienes un blog en el que tienes dos tablas en la base de datos:

- **Posts**: donde están se guardan los *posts* y que tienen un campo relacional con la siguiente tabla.
- **Categories**: donde están las categorias donde se ubican los *posts*.

Ahora yo quiero hacer los siguiente. Quiero mostrar sólo las categorias que tienen *posts* y obviamente, los *posts*. Todo bien hasta que quieres que los *posts* aparezcan con paginación... la cosa se complica ya que la consulta a los *posts* estará paginada y por tanto mostrará solo las categorias que aparezcan en los resultados de la paginación actual. Yo lo que quiero son todas las categorias que tengan *posts*.

Mi primer planteamiento es hacer la consulta principal:

```php 
$posts = Post::query()
    ->with('categories:id,name')
    ->orderBy('created_at', 'desc');
```

Ahora realizo dos consultas a partir de esta:

```php 
// Obtengo las categorias
$categories = $posts
    ->plunk('categories')
    ->unique();

// Obtengo los posts paginados
$listOfposts = $posts->paginate(15);
```

Ahora tengo la lista de categorias que tienen *posts* y la lista de *posts* con paginación. En total 2 consultas a la base de datos... pero yo quiero sólo una. Entonces planteo la siguiente opción:

```php 
// Obtengo las categorias pero como Collection en vez de Builder como hacía antes
$posts = Post::query()
    ->with('categories:id,name')
    ->orderBy('created_at', 'desc')
    ->get();

$categories = $posts
    ->plunk('categories')
    ->unique();

$listOfposts = $posts->paginate(15);
```

Obviamente, `paginate()` no es un método de colección (*Collection*) válido, por lo que no funciona. Pero en teoría, esta sería la forma de hacerlo con una sola consulta. Mi siguiente paso es ver si me dejan paginar una colección a lo bruto:

```php 
public function pagination(Collection $data)
{
    $items = $data->forPage($currentPage, $perPage);
    $totalResults = $data->count();
    $perPage = 15;
    $currentPage = request('page') ?: (Paginator::resolveCurrentPage() ?: 1);

    return new LengthAwarePaginator(
        $items,
        $totalResults,
        $perPage,
        $currentPage,
        // Esta parte la copie de lo que hace por defecto el paginador de Laravel haciendo un dd()
        [
            'path' => url()->current(),
            'pageName' => 'page',
        ]
    );
}
```

Y ahora pruebo todo junto:

```php 
$posts = Post::query()
    ->with('categories:id,name')
    ->orderBy('created_at', 'desc')
    ->get();

$categories = $posts
    ->plunk('categories')
    ->unique();

$listOfposts = $this->pagination($posts);

public function pagination(Collection $data)
{
    $items = $data->forPage($currentPage, $perPage);
    $totalResults = $data->count();
    $perPage = 15;
    $currentPage = request('page') ?: (Paginator::resolveCurrentPage() ?: 1);

    return new LengthAwarePaginator(
        $items,
        $totalResults,
        $perPage,
        $currentPage,
        // Esta parte la copie de lo que hace por defecto el paginador de Laravel haciendo un dd()
        [
            'path' => url()->current(),
            'pageName' => 'page',
        ]
    );
}
```

Y misteriosamente ha funcionado... ahora solo hago una consulta a la base de datos.