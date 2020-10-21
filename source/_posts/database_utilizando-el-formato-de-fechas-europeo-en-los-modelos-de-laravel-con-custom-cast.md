---
extends: _layouts.post
section: content
title: Utilizando el formato de fechas europeo en los Modelos de Laravel
date: 2020-10-21
description: Creación de un <Custom Cast> en el Modelo para la gestión del formato de fechas en Laravel de forma automática.
categories: [database, laravel]
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
    private string $dateFormat = 'd/m/Y';

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
            ? Carbon::createFromFormat($this->dateFormat, $value)
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
    'fertilization_date' => \App\Models\Casts\DateFormat::class,
];
```

Esto en principio funciona, pero tiene una pega. Si los datos que enviamos a la base de datos no están en formato europeo va a dar error... por lo general, somos nostros quienes controlamos el formato de los datos, pero a veces al utilizar librerías de terceros o una API se puede complicar... y no quiero estar comprobando formatos continuamente, así que la mejor opción es mejorar el código para que lo haga directamente él.

```php
<?
namespace App\Models\_Casts;

use Illuminate\Contracts\Database\Eloquent\CastsAttributes;
use Carbon\Carbon;

class DateFormat implements CastsAttributes
{
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
            ? Carbon::parse($value)->format($this->getFormat)
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
        // The field has the database format
        if($this->checkDate($value)) {
            return $value;
        }

        // The field has not the database format
        return strlen($value)
            ? Carbon::createFromFormat($this->getFormat, $value)
            : null;
    }

    /**
     * Evaluate the format in order to store in the database
     */
    private function checkDate(?string $date): bool
    {
        return Carbon::createFromFormat($this->setFormat, $date)->format($this->setFormat) === $date;
    }
}
```

Lo que hemos hecho es añadir el método `heckDate()`, cuya función es la de verificar si la fecha está en formato `timestamp`. Si es el caso, se envia la fecha a la base de datos tal cual está. 

Se podría hacer lo mismo con el formato estadounidense, pero de momento no me he visto en la situación de tener que hacerlo...
