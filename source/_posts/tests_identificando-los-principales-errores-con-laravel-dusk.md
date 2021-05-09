---
extends: _layouts.post
section: content
title: Cómo solucionar los principales errores con Laravel Dusk y orchestral/testbench-dusk.
date: 2021-05-09
description: Algunos ejemplos prácticos del como solucionar los más recurrentes errores con Laravel Dusk y orchestral/testbench-dusk.
categories: [laravel, tests, packages, php]
---

Este artículo, es al final un pequeño recordatorio para cuando me pongo a hacer tests con **Laravel Dusk** y empiezan a surgir los errores al hacer las pruebas. 

He intentado recopilar los principales errores que me he encontrado, y como los he terminado por solucionar. Empecemos por los errores generados por el *driver* de **Chrome**:

```
Facebook\WebDriver\Exception\SessionNotCreatedException: session not created: Chrome version must be between 70 and 73
```

```
Facebook\WebDriver\Exception\WebDriverCurlException: Curl error thrown for http POST to /session with params: {"capabilities":{"firstMatch":[{"browserName":"chrome","goog:chromeOptions":{"w3c":false}}]},"desiredCapabilities":{"browserName":"chrome","platform":"ANY","chromeOptions":{"w3c":false}}}
```

```
Failed to connect to localhost port 9515: Connection refused
```

En función de si estamos trabajando directamente con **Laravel Dusk**, o si estamos creando un *package* para **Laravel**, tenemos las siguiente soluciones:

#### Con **Laravel Dusk**:

```bash
php artisan dusk:chrome-driver
```

#### Con **orchestral/testbench-dusk**:

```bash
./vendor/bin/dusk-updater update
```

Otro error que suele suceder cuando estamos utilizando **orchestral/testbench-dusk**, es el siguiente:

```
Illuminate\Contracts\Container\BindingResolutionException: Target class [livewire] does not exist.
```

En este caso el error ocurre al no encontrar la clase **Livewire**, pero puede suceder con cualquier clase que se nos olvide añadir. Sucede debido a que en la clase *TestCase*, nos ha faltado añadir el *Service Provider* para la **Livewire**:

```php
/**
 * Load the service providers.
 */
protected function getPackageProviders($app)
{
    return [
        LivewireServiceProvider::class,
        ExcelServiceProvider::class,
    ];
}
```

No hay que olvidar el *Service Provider* del propio *package* que estamos probando (en el ejemplo anterior no lo he incluido). 

Otro problema que sucede a veces, es que no se defina correctamente el archivo `phpunit.xml.dist`, por lo que no se debe olvidar añadir los diferentes directorios utilizados para las pruebas:

```xml
<testsuites>
    <testsuite name="Browser">
        <directory suffix="Test.php">./tests/Browser</directory>
    </testsuite>
    <testsuite name="Feature">
        <directory suffix="Test.php">./tests/Feature</directory>
    </testsuite>
    <testsuite name="Unit">
        <directory suffix="Test.php">./tests/Unit</directory>
    </testsuite>
</testsuites>
```

### Referencias:

+ https://github.com/orchestral/testbench-dusk
+ https://github.com/livewire/livewire/blob/master/tests/Unit/TestCase.php
+ https://github.com/livewire/livewire/blob/master/tests/Browser/TestCase.php
+ https://github.com/laravel/dusk/issues/649
+ https://barryvanveen.nl/blog/61-how-to-fix-common-laravel-dusk-problems
+ https://laravel.com/docs/8.x/dusk#introduction
