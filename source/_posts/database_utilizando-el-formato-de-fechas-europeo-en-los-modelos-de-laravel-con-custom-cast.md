---
extends: _layouts.post
section: content
title: Utilizando el formato de fechas europeo en los Modelos de Laravel
date: 2020-10-21
update: 2021-05-10
description: Creación de un <Custom Cast> en el Modelo para la gestión del formato de fechas en Laravel de forma automática.
categories: [database, laravel]
cover_image: laravel-date-format.jpg
---

La gestión de las fechas con `Laravel` puede ser un poco complicado, sobre todo, porque el formato de fechas en Europa es diferente al formato estadounidense y diferente al formato utilizado por las bases de datos.

Por ejemplo en Europa utilizados el formato `d/m/Y`, en Estados Unidos utilizan el formato `m/d/Y` y las bases de datos utilizan el formato `Y-m-d`...

Por defecto `Laravel` va a utilizar el formato de la base de datos (`timestamp`), es decir el formato `Y-m-d H:i:s`, por lo que tendremos que adaptarlo si queremos que en nuestro proyecto se muestren en formato europeo.

Para ello tenemos varias opciones. La primera sería mediante `Accessors` y `Mutators`, los cuales tenemos que añadir en el modelo:

```php
/**
 * Fecha en formato europeo
 *
 * @param  string  $value
 * @return string
 */
public function getDateAttribute($value)
{
    return $value->format('d/m/Y');
}

/**
 * Fecha en formato base de datos
 *
 * @param  string  $value
 * @return string
 */
public function setDateAttribute($value)
{
    $this->attributes['date'] = $value->format('Y-m-d');
}
```

Así saldríamos del paso, pero tendríamos que hacer esto en cada modelo... no es una solución práctica para un proyecto medio.

Lo ideal será utilizar un `CAST` personalizado, como los que vienen por defecto en `Laravel`:

```php
/**
 * The attributes that should be cast.
 *
 * @var array
 */
protected $casts = [
    'is_admin' => 'boolean',
];
```

Y automáticamente `Laravel` gestionará el campo como boleano. Ahora se trata de hacer lo mismo pero para fechas, y lo primero será crear una clase nueva (yo las guardo en la carpeta `App\Models\Casts`):

```php
<?php

namespace App\Models\Casts;

use Illuminate\Contracts\Database\Eloquent\CastsAttributes;
use Carbon\Carbon;

class DateFormat implements CastsAttributes
{
    /**
     * private @var format
     */
    private string $getFormat = 'd/m/Y';
    private string $setFormat = 'Y-m-d';

    /**
     * Cast the given value.
     *
     * @param  \Illuminate\Database\Eloquent\Model  $model
     * @param  string  $key
     * @param  mixed  $value
     * @param  array  $attributes
     * @return array
     */
    public function get($model, $key, $value, $attributes)
    {
        return strlen($value)
            ? Carbon::parse($value)->format($this->dateFormat)
            : null;
    }

    /**
     * Prepare the given value for storage.
     *
     * @param  \Illuminate\Database\Eloquent\Model  $model
     * @param  string  $key
     * @param  array  $value
     * @param  array  $attributes
     * @return string
     */
    public function set($model, $key, $value, $attributes)
    {
        return strlen($value)
            ? Carbon::parse($value)->format($this->setFormat)
            : null;
    }
}
```

Y la utilización en el modelo sería:

```php
/**
 * The attributes that should be cast.
 *
 * @var array
 */
protected $casts = [
    'my_date' => \App\Models\Casts\DateFormat::class,
];
```

Espero que sea útil.
