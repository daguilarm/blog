---
extends: _layouts.post
section: content
title: Actualizando a php 7.4 desde Mac
date: 2019-12-03
description: Actualizando un Mac a php 7.4. Problemas y retos.
cover_image: /assets/img/posts/php74.jpg
categories: [php]
---

Ha salido la nueva versión de php: la **versión 7.4** con grandes novedades. Destacando las *arrow functions* que llevaban siendo (desde hace tiempo), una reivindicación por parte de la comunidad php:

```php 
<?php

$factor = 10;
$nums = array_map(fn($n) => $n * $factor, [1, 2, 3, 4]);
// $nums = array(10, 20, 30, 40);
```

Podrás encontrar más informacion sobre las novedades, aquí: [php.net](https://www.php.net/manual/es/migration74.new-features.php){.link-out}

En cualquier caso, la idea de este post era la de exponer mi experiencia al actualizar mi Mac, y explicar como lo he hecho, y sobre todo, que problemas he encontrado.

Partimos de la base, de que la gestión de mi servidor local la realizo a través de [Laravel valet](https://laravel.com/){.link-out}, y por tanto, solo he tenido que hacer esto:

```bash 
valet use php@7.4
```

Automáticamente me ha indicado que no tenía instalada la versión 7.4, y la ha instalado directamente. 

Admito que no ha sido mi primera tentativa, ya que anteriormente, había intentado instalarla utilizando `brew`... y no fue la mejor de las opciones, realmente, fue un auténtico desastre y no solo porque no me ha instaló la nueva versión, sino porque que me borró el archivo de configuración de mysql:

```bash 
/usr/local/etc/my.cnf.d
```

Por lo que he tenido que crearlo de nuevo:

```bash 
mkdir /usr/local/etc/my.cnf.d
```
Importante, no olvidar actualizar `valet` antes:

```bash 
composer global update && valet install
```

Otros usuarios, se han encontrado otros problemas, por ejemplo, [Jeffrey Way](https://laracasts.com/){.link-out}, ha tenido problemas con `ngix` y `dnsmasq`, y ha recomendado actualizarlos:

```bash 
brew upgrade nginx && brew upgrade dnsmasq
```

También recomienda eliminar versiones anteriores de `php`:

```bash 
brew unlink php@7.2
```

En mi caso, lo hizo automáticamente `valet`...

En fin, creo que que si usas **Mac** y **Laravel**, lo mejor para actualizar `php` es hacerlo desde `valet`, o al menos, ha sido lo más sencillo para mi.
