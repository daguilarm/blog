---
extends: _layouts.post
section: content
title: Buscador con Laravel Livewire y AlpineJS
date: 2020-10-09
description: Buscador desarrollado con el framework Laravel, el package Livewire y el framework para JavaScript AlpineJS
categories: [laravel, livewire, alpinejs]
---

El objetivo de este artículo es explicar cómo desarrollar un buscador con Livewire y complementado con AlpineJS, mi nuevo framework favorito para JavaScript.

Lo primero es crear el componente para Livewire:

```bash
php artisan make:livewire search
```

Y nos generará dos archivos, uno ubicado en la carpeta `app\Http\Livewire\Search.php` y el otro (con las vistas) en la carpeta `resources/views/livewire/search.blade.php`. Ya tenemos todo listo para empezar (siempre que tengamos Livewire y AlpineJS configurados en nuestro proyecto). Empezaremos por el archivo de las vistas:

```html
<div style="position:relative" x-data="inputSearch()">
    <!-- Campo de búsqueda -->
    <input 
        type="text" 
        x-on:keydown="iconReset = true" 
        wire:model="search" 
        placeholder="Introduzca el término a buscar..."
    >
    <!-- Icono para borrar el campo de búsqueda (ajústalo con tu css) -->
    <div style="position: absolute" x-show="iconReset">
        <svg 
            class="h-5 w-5 mt-1 cursor-pointer" 
            x-on:click="iconReset = false" 
            wire:click="clearSearch" 
            xmlns="http://www.w3.org/2000/svg" 
            fill="none" 
            viewBox="0 0 24 24" 
            stroke="currentColor"
        >
            <path 
                stroke-linecap="round" 
                stroke-linejoin="round" 
                stroke-width="2" 
                d="M6 18L18 6M6 6l12 12"
            >
            </path>
        </svg>
    </div>
</div>

<script>
    function inputSearch() {
        return {
            iconReset: false,
            search: '',
        }
    }
</script>
```

La idea es que cuando empecemos a escribir aparezca un icono ("X") para borrar el contenido del campo y resetear la búsqueda. Yo personalmente creo en mi `layout.blade.php` un campo para ir añadiendo el código JavaScript al final de la página:


```html
@stack('javascript')
```

Y el código JavaScript quedaría así:

```html
@push('javascript')
    <script>
        function inputSearch() {
            return {
                iconReset: false,
                search: '',
            }
        }
    </script>
@endpush
```

Pero esto ya depende de cada uno, y de cómo organice su proyecto. Continuemos con el archivo `app\Http\Livewire\Search.php`:

```php
<?php

namespace App\Http\Livewire;

use Illuminate\Support\Facades\DB;
use Livewire\Component;

class NavbarInputSearch extends Component
{
    public $search;
    public $model;
    public $fields;
    public $relationships;

    protected $queryString = [
        'search' => ['except' => ''],
    ];

    public function mount()
    {
        // Definimos los campos de la tabla en los que queremos buscar
        $this->fields = ['field1', 'field2'];
        // Si queremos añadir relaciones para evitar el N+1
        $this->relationships = ['relationship'];
        //Definimos el modelo 
        $this->model = '\App\Models\YourModel';
    }

    public function render()
    {
        return view('livewire.search', [
            'results' => empty($this->search) ? collect() : $this->query(),
        ]);
    }

    public function resetInput()
    {
        $this->reset('search');
    }

    private function query()
    {
        return $this->whereConditions()
            // Si no queremos añadir relationships lo quitamos...
            ->with($this->relationships)
            // Por ejemplo...
            ->take(10)
            ->get();
    }

    private function whereConditions()
    {
        $query = $this->model::Query();

        foreach($this->fields as $field) {
            $query = $query->orWhere($field, 'like', '%' . $this->search . '%');
        }

        return $query;
    }
}
```

Ahora nos quedaría añadir a nuestra vista los resultados:

```html
<!-- Buscador -->
<div style="position: relative" x-data="inputSearch()">
    <!-- Campo de búsqueda -->
    <input 
        type="text" 
        x-on:keydown="iconReset = true" 
        wire:model="search" 
        placeholder="Introduzca el término a buscar..."
    >
    <!-- Icono para borrar el campo de búsqueda (ajústalo con tu css) -->
    <div style="position: absolute" x-show="iconReset">
        <svg 
            class="h-5 w-5 mt-1 cursor-pointer" 
            x-on:click="iconReset = false" 
            wire:click="clearSearch" 
            xmlns="http://www.w3.org/2000/svg" 
            fill="none" 
            viewBox="0 0 24 24" 
            stroke="currentColor"
        >
            <path 
                stroke-linecap="round" 
                stroke-linejoin="round" 
                stroke-width="2" 
                d="M6 18L18 6M6 6l12 12"
            >
            </path>
        </svg>
    </div>
</div>

<!-- Resultados -->
@isset($results)
    <ul>
        @foreach($results as $item)
            <li>
                {{ $item->nombre_del_campo }}
            </li>
        @endforeach
    </ul>
@endisset

<!-- Código JavaScript -->
<script>
    function inputSearch() {
        return {
            iconReset: false,
            search: '',
        }
    }
</script>
```

Básicamente sería así... Más información aquí:

- [https://laravel-livewire.com/docs/2.x/making-components](https://laravel-livewire.com/docs/2.x/making-components){.link-out}
- [https://laravel-livewire.com/docs/2.x/query-string](https://laravel-livewire.com/docs/2.x/query-string){.link-out}
