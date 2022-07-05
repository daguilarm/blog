---
extends: _layouts.post
section: content
title: Novedades en Laravel 9
date: 2022-03-15
updated: 2022-07-05
description: Todas las novedades del framework Laravel, en la nueva versión 9. Todo lo nuevo que viene en el Framework PHP, explicado en profundidad y con muchísimas nuevas características.
categories: [laravel, php, frameworks]
---

**Laravel** es probablemente el **Framework PHP** más utilizado del momento, y cada vez que sale una nueva versión, revoluciona un poco a la comunidad de desarrolladores, y no es para menos, ya que las decisiones que se tomen en torno a su desarrollo, va a afectar directamente a todos los que desarrollamos proyectos mediante este Framework. 

Actualmente, **Laravel** sigue un ciclo de actualizaciones anual (en cuanto a versiones principales), por lo que es previsible que cada año, **en torno a Febrero, se libere una nueva versión**. En cuanto a versiones menores, lo normal es que se actualice cada semana, corrigiendo errores, actualizando packages, etc...

Empecemos por las novedades de esta nueva actualización:

1) **Laravel ahora requiere php 8** como versión mínima para funcionar, modernizando considerablemente el funcionamiento interno del framework, utilizando las nuevas características como la compilación JIT, o la nueva sistaxis de los constructores,...

2) Se ha sustituido **Swift Mailer** (la librería usada para enviar emails por parte de Laravel desde los primeros tiempos), por **Symfony Mailer**.

3) Migraciones anónimas. A partir de ahora (realmente desde la versión 8.37) Laravel puede realizar migraciones anónimas, evitando así el problema de migraciones con el mismo nombre, que puedan colisionar entre sí:

```php
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('mi_tabla', function (Blueprint $table)
        {
            $table->string('name')->nullable();
        });
    }
};
```

4) Nueva forma de añadir rutas agrupadas en los controladores:

```php
Route::controller(PhotoController::class)
    ->group(function () {
        Route::get('/photo/{id}', 'show');
        Route::post('/photo', 'store');
    });
```

Teniendo un mayor control sobre las rutas que queremos añadir, ya que no siempre vamos a necesitar utilizar ```Route::resource('photos', PhotoController::class);```

5) Laravel ha incorporado en su código los retornos de tipos, en sus métodos. En principio esto es solo una mejora interna, pero es importante tenerlo en cuenta:

```php
count(): int
getIterator(): Traversable
getSize(): int
jsonSerialize(): array
offsetExists($key): bool
offsetGet($key): mixed
offsetSet($key, $value): void
offsetUnset($key): void
```

6) **Cambio en la gestión de los accessors y mutators en los modelos**. Ahora podemos utilizar las mejoras de PHP 8, para gestionar de forma más sencilla estos campos:

```php 
use Illuminate\Database\Eloquent\Casts\Attribute;

public function username(): Attribute
{
  return new Attribute(
    get: fn ($value) => strtoupper($value),
    set: fn ($value) => $this->field_1 . ' - ' . $this->field_2,
  );
}
```

Ahora podemos usar ```get```y ```set``` para definir si es un accessor o un mutator, simplificando considerablemente el código en nuestros modelos.

7) **Nuevas funciones Helper** en Laravel: ```str()``` y ```to_route()```. 

Empecemos por el primer método, que no es otra cosa que un alias para ```Str::of($string)```, pero que sin lugar a dudas puede ser de gran utilidad:

```php 
// Sin helper 
Str::of('hola mundo')->upper();

// Con helper 
str('hola mundo')->upper();
```

El otro helper, nos ayudará con las redirecciones:

```php 
// Sin helper 
return redirect()->route('dashboard');

// Con helper 
return to_route('dashboard');
```

8) Integración de las busquedas FULLTEXT en la base de datos.

Ahora podemos definir un índice ```fulltext``` en nuestra migración:

```php 
$table->text('description')->fullText();
```

Para posteriormente utilizarlo en nuestras consultas:

```php 
DB::table('posts')
    ->whereFullText('description', 'lo que sea')
    ->get();
```

9) **Posibilidad de añadir las enumeraciones como ```cast```en nuestros modelos**.

Añadimos la opción en el modelo:

```php 
use App\Enums\UserStatus;

/**
 * The attributes that should be cast.
 *
 * @var array
 */
protected $casts = [
    'status' => UserStatus::class,
];
```

Y generamos la clase:

```php 
enum UserStatus: string
{
    case success = 'validate';
    case error = 'no_validate';
}
```

10) Siguiendo con los ```Enums```, ahora podemos utilizarlos directamente desde las rutas (**implicit route bindings**):

```php
enum Category: string
{
    case Fruits = 'fruits';
    case People = 'people';
}
```

Ahora podemos llamar directamente a las categorias:

```php 
Route::get('/categories/{category}', function (Category $category) {
    return $category->value;
});
```

11) Resolver relaciones entre modelos padre e hijo, directamente desde una ruta:

```php 
use App\Models\Article;
use App\Models\User;

Route::get('/users/{user}/articles/{article}', function (User $user, Article $article) {
    return $article;
})->scopeBindings();
```

En este caso, directamente mostrará los artículos de el usuario seleccionado.

12) Laravel 9 llega con el nuevo **motor de búsqueda Laravel Scout, que permite realizar búsquedas ```fullText``` en Eloquent**. Simplemente hay que añadir un *Trait* a nuestro modelo para que funcione:

```php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Laravel\Scout\Searchable;

class Article extends Model
{
    use Searchable;
}
```

Este sistema es una alternativa a **Angolia** o **MeiliSearch**, para bases de datos pequeñas o medianas, y con una carga pequeña.

13) **Renderizar Blade directamente desde código**.

Ahora podemos ejecutar directamente blade desde nuestro controlador, o desde una ruta. Para ello, simplemente tendremos que utilizar el método ```render()```.

```php 
return Blade::render('Hello, {{ $name }}', ['name' => 'Julian Bashir']);
```

14) **Mejoras en Blade**. 

Ahora se pueden usar simplificaciones a la hora de generar ```@slots``` en los **Componentes** de ***Blade**. Veamos un ejemplo de cómo se hacía hasta ahora:

```html
<x-slot name="title">
    Server Error
</x-slot>
```

Ahora veamos la forma simplificada:

```html
<x-slot:title>
    Server Error
</x-slot>
```

También se han integrado dos nuevas directivas, para simplificar los formularios: ```@checked``` y ```@selected```. Veamos como funcionan:

```html 
<input 
    type="checkbox"
    name="active"
    value="active"
    @checked(old('active', $user->active)) 
/>

<select name="version">
    @foreach ($product->versions as $version)
        <option value="{{ $version }}" @selected(old('version') == $version)>
            {{ $version }}
        </option>
    @endforeach
</select>
```

Personalmente, una implementación que voy a utilizar.

15) Paginación de resultados usando **Bootstrap 5**. En el caso que no utilices ```tailwindcss``` ahora puedes integrar también bootstrap. Simplemente hay que definirlo en el **Service Provider**:

```php 
use Illuminate\Pagination\Paginator;
 
/**
 * Bootstrap any application services.
 *
 * @return void
 */
public function boot()
{
    Paginator::useBootstrapFive();
}
```

Y mucho más, simplemente puedes consultar esta la guia oficial de [Laravel](https://laravel.com/docs/9.x/releases){.link-out}