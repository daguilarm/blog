---
extends: _layouts.post
section: content
title: Configurar helpers en Laravel
date: 2019-11-15
description: Helpers en Laravel con composer y service providers.
categories: [composer, laravel, php, frameworks]
---

En ocasiones, podemos necesitar acceder a funciones (*helpers*), desde cualquier parte de nuestro código.

**Laravel** no dispone de esta funcionalidad por defecto, pero existen varias formas de configurar nuestra aplicación, para solucionar esto.

Antes de empezar con las diferentes opciones que tenemos, lo primero es crear un archivo donde alojar nuestras funciones o *helpers*, en mi caso, suelo tener el archivo aquí:

```php
\App\Http\Helpers
```

En este nuevo archivo: `Helpers.php`, añadiremos todos los métodos que necesitemos:

```php
<?php

if (! function_exists('userId')) {
    function userId() {
        return auth()->user()->id;
    }
}
```

Ahora es cuando podemos elegir entre las diferentes opciones para poder tener acceso a los *helpers*.

####a) Mediante el archivo `composer.json`

Añadimos el campo `files`, con la ruta hacia nuestro archivo.

```php
"autoload": {
    "psr-4": {
        "App\\": "app/"
    },
    "classmap": [
        "database/seeds",
        "database/factories"
    ],
    "files":[
        "app/Http/Helpers.php"
    ]
},
```

Ahora solo nos falta actualizar `composer`, y ya estaría:

```php
composer dump
```

####b) Mediante un *Service Provider*

Crea un nuevo *Services Provider*, usando `artisan`:

`artisan make:provider HelpersServiceProvider`

El archivo se crea en la ruta:

`\app\Providers\HelpersServiceProvider.php`

Y en el archivo, en el método `register()`, añadimos:

```php
public function register()
{
    require_once app_path() . '/Http/Helpers.php';
}
```

Es decir, la ruta a nuestro archivo `helpers`.

Y ahora en el archivo:

`config/app.php`

Debemos añadir el nuevo *Service Provider* a la lista:

```php
App\Providers\HelpersServiceProvider::class,
```

De estas dos opciones, personalmente, prefiero la segunda, aunque ambas son igualmente válidas.
