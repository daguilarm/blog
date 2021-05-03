---
extends: _layouts.post
section: content
title: Nuevo package para Laravel para selects dependientes multinivel (combobox)
date: 2021-05-02
description: Package para la gestión de selects dependientes multinivel para Laravel utilizando Livewire y TailwindCSS. 
categories: [laravel, Livewire, packages, packagist, php]
---

Estoy trabajando en un nuevo proyecto y necesitaba un sistema de `selects` dependientes y con niveles de dependencia infinitos. Revisando `packages` para **Laravel** ya desarrollados me he encontrado con herramientas parecidas a [https://select2.org/](https://select2.org/){.link-out}, que son geniales, pero me sobraban gran parte de las funcionalidades que tenían, además, quería que estuviera basado en `back-end` en vez de en `front-end`.

Encontré soluciones, pero supongo que soy un maniático con el código y quería que además fuese fluido y fácilmente entendible, utilizando métodos encadenados. Al final me puse a desarrollar mi propio `package`, porque no encontraba nada que me gustase:

- [https://github.com/daguilarm/livewire-combobox](https://github.com/daguilarm/livewire-combobox){.link-out}

![Laravel Livewire combobox - selects dependientes](/assets/img/projects/liveware-combobox.gif)

Básicamente, tenemos que crear un componente **Livewire**, como el siguiente:

```php
<?php

declare(strict_types=1);

namespace App\Http\Livewire;

use App\Models\Car;
use App\Models\Extra;
use App\Models\Option;
use Daguilarm\LivewireCombobox\Components\ComboboxLivewireComponent;
use Daguilarm\LivewireCombobox\Components\Fields\Select;
use Daguilarm\LivewireCombobox\Contracts\Combobox;

class ComboboxCars extends ComboboxLivewireComponent implements Combobox
{
    public function elements(): array
    {
        return [
            Select::make('Vehículos', Car::class)
                ->uriKey('key-for-car')
                ->options(function($model) {
                    return $model
                        ->pluck('name', 'id')
                        ->toArray();
                }),
            Select::make('Opciones de vehículos', Option::class)
                ->uriKey('key-for-options')
                ->dependOn('key-for-car')
                ->foreignKey('car_id')
                ->selectRows('id', 'option')
                ->hideOnEmpty(),
            Select::make('Extras de vehículos', Extra::class)
                ->uriKey('key-for-extras')
                ->dependOn('key-for-options')
                ->foreignKey('option_id')
                ->selectRows('id', 'extra')
                ->hideOnEmpty(),
        ];
    }
}
```

Y añadir el componente a la vista, tal y como se muestra a continuación:

```html 
<div>
    <livewire::combobox-cars />
</div>
```

Y automáticamente tendremos 3 campos `select` dependientes unos de otros, sin tener que hacer nada mas. Y desde mi punto de vista, de forma clara, fluida y con métodos encadenados, tal y como a mi me gusta.
