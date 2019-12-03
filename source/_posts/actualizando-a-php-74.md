---
extends: _layouts.post
section: content
title: Actualizando a php 7.4
date: 2019-12-03
description: Actualizando un Mac a php 7.4. Problemas y retos.
cover_image: /assets/img/posts/php74.jpg
---

Ha salido la nueva versión de php, la versión 7.4 con grandes novedades. Destacando las "arrow functions" que llevaban siendo (desde hace tiempo), una reivindicación por parte de la comunidad php:

```php 
<?php

$factor = 10;
$nums = array_map(fn($n) => $n * $factor, [1, 2, 3, 4]);
// $nums = array(10, 20, 30, 40);
```

Podrás encontrar más informacion sobre las novedades, aquí: [php.net](https://www.php.net/manual/es/migration74.new-features.php)

En cualquier caso, la idea de este post, era la de exponer mi experiencia al actualizar mi Mac, y explicar como lo he hecho, y que problemas me he encontrado.

La gestión de mi servidor local, la realizo a través de [Laravel valet](https://laravel.com/), y por tanto, solo he tenido que hacer esto:

```bash 
valet use php@7.4
```

Automáticamente me ha indicado que no tenía instalada la versión, y la ha instalado. 

Admito que no ha sido mi primera opción, ya que anteriormente había intentado instalarla utilizando `brew`... y no fue una buena opción, fue un auténtico desastre, y no solo porque no me ha instaló la nueva versión, sino que me borró el archivo de configuración de mysql:

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

En fin, creo que que si usas **Mac** y **Laravel**, hacerlo desde `valet` es la mejor opción.
