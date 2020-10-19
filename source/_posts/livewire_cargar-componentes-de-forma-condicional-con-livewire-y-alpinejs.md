---
extends: _layouts.post
section: content
title: Cargar componentes de forma dinámica y condicional con Laravel Livewire y AlpineJS - Fracasos y éxitos
date: 2020-10-18
description: Código para cargar componentes de Laravel Livewire de forma dinámica mediante AlpineJS, y todo ello, de forma condicional con window.Livewire.rescan()
categories: [laravel, livewire, alpinejs]
---

Me he encontrado en la situación de querer cargar componentes de Laravel Livewire de forma condicional, y todo ello, en función de un campo `select` o de un simple *click* en un enlace (en mi caso se trataba de un sistema de pestañas y contenedores). 

La idea era no cargar nada de inicio y en función de la selección, ir cargando de forma dinámica un componente determinado tal y como se hubiera hecho con `Jquery`. Terminando con la carga del resultado de la consulta `AJAX` en un contenedor `div`:

```javascript
$("button").on('click', function(){
    $("#div").load("ajaxResponse.php");
});
```

El sistema que planteo tiene un reto más, y es el de reutilizar componentes `Livewire` que ya he utilizado en otra parte del proyecto, y por tanto, no tener que repetir código. Esto tiene un problema (realmente tiene varios), y es que no puedo modificar (ni adaptar) el componente original que voy a cargar en el contenedor, ya que al hacerlo, podría dejar de funcionar en su ubicación original, y al final la solución se convierte en problema.

El planteamiento era más o menos así:

```html
<span x-data="{load: 0}"
    <div id="selectors">
        <a href="#" x-click="load = 1">Cargar contenido 1</a>
        <a href="#" x-click="load = 2">Cargar contenido 2</a>
        <a href="#" x-click="load = 3">Cargar contenido 3</a>
    </div>
    <div id="rootContainer">
        <div x-if="load === 1">
            <livewire:component1 />
        </div>
        <div x-if="load === 2">
            <livewire:component2 />
        </div>
        <div x-if="load === 3">
            <livewire:component3 />
        </div>
    </div>
</span>
```

Y obviamente no funcionaba. Obtenía el siguiente mensaje de error:

`Uncaught TypeError: Cannot read property '$wire' of undefined`

Así que estaba empezando a pensar que tendría que hacer algo así:

```html
<span x-data="{load: 0}"
    <div id="selectors">
        <a href="#" x-click="load = 1">Cargar contenido 1</a>
        <a href="#" x-click="load = 2">Cargar contenido 2</a>
        <a href="#" x-click="load = 3">Cargar contenido 3</a>
    </div>
    <div id="rootContainer">
        <div x-show="load === 1">
            <livewire:component1 />
        </div>
        <div x-show="load === 2">
            <livewire:component2 />
        </div>
        <div x-show="load === 3">
            <livewire:component3 />
        </div>
    </div>
</span>
```

Lo cual está bien si vamos a trabajar con componentes simples. No era el caso  y encima son muchos componentes (doce en total). Donde te puedes encontrar perfectamente con 87 llamadas a la base de datos (en este caso particular)... una situación poco ideal.

El error de mi primera aproximación al problema, se debía a que cuando utilizas `x-if` tienes que utilizar la equiqueta `template`, o da error. Esta etiqueta, te obliga a tener un solo componente `root`, es decir, tienes que meter todo tu código en un contenedor `div` principal. 

El ejemplo siguiente va a dar error, ya que no dispone de un contenedor principal:

```html
//component1.blade.php

<h1>Title</h1>
<h4>Lorem, ipsum dolor sit amet consectetur adipisicing elit. Impedit sapiente pariatur error illo. Veniam, sunt reprehenderit libero rerum nobis doloribus ex error alias laudantium ipsum sit, eius mollitia necessitatibus vitae?</h4>
```

Se debe cambiar por:

```html
//component1.blade.php
<div>
    <h1>Title</h1>
    <h4>Lorem, ipsum dolor sit amet consectetur adipisicing elit. Impedit sapiente pariatur error illo. Veniam, sunt reprehenderit libero rerum nobis doloribus ex error alias laudantium ipsum sit, eius mollitia necessitatibus vitae?</h4>
</div>
```

Después de revisar media internet en busca de soluciones, llegué a este comentario en `github` sobre un problema que parecía similar:

+ [https://github.com/livewire/livewire/pull/1534](https://github.com/livewire/livewire/pull/1534){.link-out}

Y proponía una solución parecida a esta:

```html
<span x-data="{load: 0}"
    <div id="selectors">
        <a href="#" x-click="load = 1">Cargar contenido 1</a>
        <a href="#" x-click="load = 2">Cargar contenido 2</a>
        <a href="#" x-click="load = 3">Cargar contenido 3</a>
    </div>
    <div id="rootContainer">
        <template x-if="load === 1">
            <div x-data="{}" x-init="window.Livewire.rescan($el)">
                <livewire:component1 />
            </div>
        </template>
        <template x-if="load === 2">
            <div x-data="{}" x-init="window.Livewire.rescan($el)">
                <livewire:component2 />
            </div>
        </template>
        <template x-if="load === 3">
            <div x-data="{}" x-init="window.Livewire.rescan($el)">
                <livewire:component3 />
            </div>
        </template>
    </div>
</span>
```

Esta técnica, lo que hace es reiniciar cada elemento Livewire, y al hacer esto, los elementos se van visualizando conforme hacemos *click* en cada enlace, realmente es lo que estaba buscando. 

En este punto, me puse a revisar el código `HTML` y efectivamente, todo el código se había eliminado del `DOM`... el problema lo encontré al revisar las consultas a la base de datos: seguían siendo 87. 

Es decir, por un lado eliminaba el `HTML` del `DOM` hasta el momento en que se hace la llamada a través del `click` en el enlace, pero por otro lado, seguía realizando las consultas a la base de datos. 

Seguía teniendo prácticamente el mismo problema que al principio, aunque con un código `HTML` más ligero...

Mi siguiente planteamiento fue el de crear un componente `Livewire`, de modo que cada vez que se hiciera `click` en un enlace, se enviara una variable con el componente a cargar mediante `Livewire`:

```html
<a wire:click="setContainer('1')">Container 1</a>
```

Y dentro del nuevo componente `Livewire`:

```html
<span x-data="{load: 0}"
    <div id="selectors">
        <a href="#" x-click="load = 1" wire:click="setContainer('1')">Cargar contenido 1</a>
        <a href="#" x-click="load = 2" wire:click="setContainer('2')">Cargar contenido 2</a>
        <a href="#" x-click="load = 3" wire:click="setContainer('3')">Cargar contenido 3</a>
        ...
    </div>
    <div id="rootContainer">
        @if($container === 1)
            <livewire:component1 />
        @endif
        @if($container === 2)
            <livewire:component2 />
        @endif
        @if($container === 3)
            <livewire:component3 />
        @endif
        ...
    </div>
</span>
```

Y el nuevo archivo `Livewire`

```php
<?php

namespace App\Http\Livewire;

use Livewire\Component;

class Tabs extends Component
{
    public $container;

    public function setContainer($container)
    {
        $this->container = $container;
    }

    public function render()
    {
        return view('dashboard.sections.view', [
            'container' => $this->container,
        ]);
    }
}
```

Ahora solo queda cargar el componente con los enlaces y el contenedor:

```html
    <livewire:tabs container="0" :key="Str::random()" />
```

Y lo curioso es que funciona, pero da un error de JavaScript:

```javascript
Uncaught (in promise) TypeError: Cannot read property 'fingerprint' of null
```

Por lo visto este error es debido a que hay un problema con las `keys` que genera `Livewire` y por algún motivo, no he sido capaz de ver donde se han generado claves repeditas...

+ [https://github.com/livewire/livewire/issues/1686
](https://github.com/livewire/livewire/issues/1686
){.link-out}

### Actualización 19/10/2020

Bien, he encontrado una solución pero que parece un parche... y tengo la sensación que es un `bug` en `alplineJS`. Consiste en reiniciarlizar `x-data` y recargar el componente `Livewire`.

```html
<span x-data="{load: 0, error: true}"
    <div id="selectors">
        <a href="#" x-click="load = 1" wire:click="setContainer('1')">Cargar contenido 1</a>
        ...
    </div>
    <div id="rootContainer">
        <div x-data="{}" x-init="window.Livewire.rescan($el)">
            @if($container === 1)
                <livewire:component1 />
            @endif
        </div>>
        ...
    </div>
</span>
```

Aqui es donde viene lo raro, en el componente que se carga (según el ejemplo anterior `resources/views/livewire/component1`) también hay que volver a poner el código de reinicialización:

```html
<div x-data="{}" x-init="window.Livewire.rescan($el)">
    ...componente
</div>
```

Sinceramente, estoy desconcertado... sigue dando error pero ahora funciona correctamente, y si nos olvidamos del mensaje en la consola de `JavaScript es como si no pasara nada.

Seguiré investigando...
