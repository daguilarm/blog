---
extends: _layouts.post
section: content
title: Gestionando cookies con Laravel Livewire
date: 2022-07-28
description: Gestionando cookies mediante Laravel Livewire en tiempo real. Laravel livewire no permite enviar una cookie mediante Queue:cookie() y recibir respuesta en el mismo Request. Un problema si queremos un resultado en tiempo real. Veamos un ejemplo real de gestión de cookies con Laravel Livewire y cómo solucionarlo.
categories: [php, laravel, livewire]
---

Enfrentándome a un caso real, he descubierto que no es posible actualizar *cookies* en tiempo real con **Laravel Livewire**, al menos, no de forma directa. Lo bueno es que hay una solución.

El problema surge cuando utilizas `Cookie:queue()` y esperas recibir una respuesta del proceso. Por lo visto desde la versión 2.0 de **Laravel Livewire** es necesario dos `Request` para obtener un resultado, es decir, en el primero hacemos la llamada y guardamos la cookie y en el segundo la leemos. 

**Veamos un ejemplo para entenderlo mejor**. Imagina que quieres crear una *cookie* para guardar un *posts* en tu *blog*, y para ello (y para simplificarlo), vamos a usar un botón, que cuando pulsemos añada a la *cookie* el identificador de nuestro *post*. Lo que queremos ahora es que si la *cookie* se ha generado correctamente, el color del botón cambie, y como estamos usando **Livewire**, queremos que se haga en tiempo real. Planteemos el componente:

```php 
<?php

namespace App\Http\Livewire;

use Livewire\Component;
use Illuminate\Support\Facades\Cookie;

class Cookie extends Component
{
    public $uuid;

    public $cookie;

    private int $lifetime = 60 * 24 * 30;

    public function mount($uuid)
    {
        $this->uuid = $uuid;
        $this->cookie = $this->getCookie();
    }

    public function render()
    {
        return view('livewire.cookie');
    }

    public function storeCookie(string $uuid): void
    {
        // Leemos la cookie
        $cookie = $this->getCookie();

        // Añadimos el nuevo valor
        array_push($cookie, $uuid);

        // Guardamos la cookie
        Cookie::queue(
            'project-cookie',
            json_encode($cookie),
            $this->lifetime
        );
    }

    // Pasamos la cookie a formato array para poder trabajar con ella. Recuerda que se guarda como string.
    private function getCookie(): array
    {
        $cookie = Cookie::get('project-cookie') ?? json_encode([]);

        return json_decode($cookie);
    }
}
```

y nuestro componente Blade:

```html 
<div>
    @if (in_array($uuid, $cookie))
        <button
            type="button"
            class="{{ $css }} text-white bg-orange-400 hover:bg-orange-700"
            wire:click="storeCookie('{{ $uuid }}')"
        >
            <x-heroicon-s-save class="hidden xl:inline-block w-4 h-4 mr-1 opacity-70"></x-heroicon-s-save> Guardar
        </button>
    @else
        <button
            type="button"
            class="text-white bg-gray-400 cursor-default {{ $css }}"
        >
            <x-heroicon-s-bookmark class="hidden xl:inline-block w-4 h-4 mr-1 opacity-70"></x-heroicon-s-bookmark> Guardado
        </button>
    @endif
</div>
```

Al hacer *click*, se va a guardar el valor en la *cookie*, pero el botón no va a cambiar de color... Esto es debido a que el proceso no se completa en un mismo `Request`. Buscando en internet, me encontré con la respuesta en el repositorio de **Livewire**:

- [https://github.com/livewire/livewire/discussions/1787](https://github.com/livewire/livewire/discussions/1787){.link-out}

Lo que proponen es hacerlo de forma indirecta, es decir, no comprobar si el valor existe en la *cookie*, y en vez de eso, utilizar una propiedad nueva que guarde el valor del identificador del *post*. Parece un lio pero no lo es:

```php 
<?php

namespace App\Http\Livewire;

use Livewire\Component;
use Illuminate\Support\Facades\Cookie;

class Cookie extends Component
{
    public $uuid;

    public $cookie;

    private int $lifetime = 60 * 24 * 30;

    public function mount($uuid)
    {
        $this->uuid = $uuid;
        $this->cookie = $this->currentCookie();
    }

    public function render()
    {
        return view('livewire.cookie');
    }

    public function storeCookie(string $uuid): void
    {
        // Leemos la cookie
        $cookie = $this->getCookie();

        // Añadimos el nuevo valor
        array_push($cookie, $uuid);

        // Guardamos la cookie
        Cookie::queue(
            'project-cookie',
            json_encode($cookie),
            $this->lifetime
        );

        // Actualizamos la cookie 
        $this->cookie = $uuid;
    }

    // Pasamos la cookie a formato array para poder trabajar con ella. Recuerda que se guarda como string.
    private function getCookie(): array
    {
        $cookie = Cookie::get('project-cookie') ?? json_encode([]);

        return json_decode($cookie);
    }

    // Buscamos la cookie actual en nuestra cookie
    private function currentCookie(): string
    {
        return in_array($this->uuid, $cookie)
            ? $this->uuid
            : 'empty-cookie';
    }
}
```

Lo que hemos hecho, ha sido añadir a la propiedad `$cookie` el valor de la *cookie* actual. Veamos primero los cambios al inicializar el componente:

```php 
public function mount($uuid)
{
    $this->uuid = $uuid;
    $this->cookie = $this->currentCookie(); // Actualizamos la cookie 
}
```

Para ello usamos el método `currentCookie()`. Lo siguiente será actualizar el valor de la propiedad `$cookie` cuando actualicemos la *cookie*:

```php 
public function storeCookie(string $uuid): void
{
    // Leemos la cookie
    $cookie = $this->getCookie();

    array_push($cookie, $uuid);

    // Guardamos la cookie
    Cookie::queue(
        'project-cookie',
        json_encode($cookie),
        $this->lifetime
    );

    $this->cookie = $uuid; //Actualizamos la propiedad $cookie 
}
```

Y por fin hemos conseguimos actualizar el valor de la propiedad `$cookie` en tiempo real (que al final es lo que queríamos). El siguiente paso será el adapatar la lógica de nuestro archivo **Blade** a las nuevas circustancias:

```html 
<div>
    @if ($uuid !== $cookie)
        <button
            type="button"
            class="{{ $css }} text-white bg-orange-400 hover:bg-orange-700"
            wire:click="storeCookie('{{ $uuid }}')"
        >
            <x-heroicon-s-save class="hidden xl:inline-block w-4 h-4 mr-1 opacity-70"></x-heroicon-s-save> Guardar
        </button>
    @else
        <button
            type="button"
            class="text-white bg-gray-400 cursor-default {{ $css }}"
        >
            <x-heroicon-s-bookmark class="hidden xl:inline-block w-4 h-4 mr-1 opacity-70"></x-heroicon-s-bookmark> Guardado
        </button>
    @endif
</div>
```

Ahora si que funciona, y conseguimos la reatividad en tiempo real que pretendíamos desde el principio, dando un pequeño rodeo..., pero lo importante al final es que funciona, y parece ser que es la forma correcta de hacer estas cosas con **Livewire**.