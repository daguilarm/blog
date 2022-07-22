---
extends: _layouts.post
section: content
title: Laravel Pint, el corrector de estilo para PHP
date: 2022-07-21
description: Laravel Pint ha sido desarrollado por Nuno Maduro sobre PHP-CS-Fixer para conseguir un corrector de estilo para PHP, gestionado mediante Artisan. Laravel Pint es un corrector de estilo minimalista y que no necesita configuración.
categories: [laravel, php, frameworks]
---

El equipo de desarrollo de **Laravel**, con [Nuno Maduro](https://nunomaduro.com/){.link-out} a la cabeza, ha lanzado [Laravel Pint](https://github.com/laravel/pint){.link-out}. Un corrector de estilo para PHP basado en [PHP-CS-Fixer](https://github.com/FriendsOfPHP/PHP-CS-Fixer){.link-out}.

**PHP-CS-Fixer** es un corrector de estilo para **PHP** que sigue los estandars definidos en PSR1, PSR2,... estos estándars puedes encontrarlos en [PHP-FIG]{https://www.php-fig.org/psr/}{.link-out} donde se establecen normas de estilo para programar en PHP, por ejemplo:

- Los nombres de los métodos deben de escribirse usando `camelcase`.
- Los archivos PHP deben de usar sólo las etiquetas `<?php` o `<?=`.
- ...

**Laravel Pint** se encarga de lidiar con todo esto. Su funcionamiento es sencillo, recorrer todos los archivos de nuestro código en busca de incumplimientos de los estándares, y los soluciona directamente en el archivo. Lo primero que tenemos que hacer para utilizar **Laravel Pint**, es instalarlo. Para ello usaremos **Composer**:

```bash 
composer require laravel/pint --dev
```

Una vez instalado, solo tenemos que ejecutarlo en el terminal:

```bash 
./vendor/bin/pint
```

En la documentación oficial de **Laravel**, vas a encontrar muchas más funcionalidades: [https://laravel.com/docs/9.x/pint](https://laravel.com/docs/9.x/pint){.link-out}

Revisando un poco por internet, me encontré el otro día un artículo en el que se hablaba de cómo configurar **Laravel Pint** como una **Github Action**. Concretamente, este es el artículo:

- [https://laravelmagazine.com/blog/run-laravel-pint-as-part-of-your-ci-pipeline-with-github-actions](https://laravelmagazine.com/blog/run-laravel-pint-as-part-of-your-ci-pipeline-with-github-actions){.link-out}

Básicamente, te explica que tienes que crear una carpeta en la base de tu directorio para añadir las **Github Actions**:

```bash 
.github/workflows
```

Y dentro de la carpeta, añadir un archivo `.yml`, por ejemplo: `pint.yml`, donde debemos añadir el siguiente código:

```bash 
name: Laravel Pint
on:
  workflow_dispatch:
  push:
    branches-ignore:
      - 'dependabot/npm_and_yarm/*'
jobs:
  phplint:
    runs-on: ubuntu-latest
    steps:
      - uses: actions/checkout@v3
        with:
          fetch-depth: 2
      - name: "laravel-pint"
        uses: aglipanci/laravel-pint-action@0.1.0
        with:
          preset: laravel
      - name: Commit changes
        uses: stefanzweifel/git-auto-commit-action@v4
        with:
          commit_message: Laravel Pint
          skip_fetch: true
```

Y en cuanto hagas un `commit` a **Github**, se ejecutará la acción, **Laravel Pint** corregirá el código y creará un PR en tu repositorio. Muy útil para cuando trabajas en equipo, no tanto cuando estás tu solo. Personalmente, prefiero ejecutar **Laravel Pint** a voluntad en vez de automatizarlo.