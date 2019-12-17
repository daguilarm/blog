---
extends: _layouts.post
section: content
title: Configurar Github webhooks con Packagist
date: 2019-12-16
description: Configurar los webhooks de Github para que se sincronicen con Packagist
categories: [packages, github, packagist]
---

Crear un package con **[Laravel](https://laravel.com/){.link-out}**, subirlo a **[Github](https://github.com/){.link-out}** y publicarlo en **[Packagist](https://packagist.org/){.link-out}**, es bastante sencillo, el problema suele venir cuando intentamos que que se sincronicen entre ellos.

El primer aviso, lo dará **Packagist**, informando que tenemos que ir a **Github** y activar los *webhooks*, para que se actualice automáticamente, por lo que nuestro primer paso será ese: ir a **Github**.

Debemos entrar en nuestro repositorio, ir a `settings` y pulsar en *webhooks*. Básicamente, sería lo mismo que:

    https://github.com/github-username/my-repository-name/settings/hooks

Si ya existe un *webhook* hacia **Packagist** lo editamos, y si no, lo creamos.

![Github webhooks](../../../assets/img/posts/github-webhooks-1.png){.thumbnail}

Debemos rellenar los campos como se describe a continuación:

![Github webhooks](../../../assets/img/posts/github-webhooks-2.png){.thumbnail}

+ **Payload URL**: https://packagist.org/api/update-package?username=USERNAME (usando el USERNAME de **Packagist**).
+ **Content type**: seleccionamos *application/json*.
+ **Secret**: es nuestra API KEY de **Packagist**. Vamos a `profile > show API Token` y añadimos este valor al campo de **Github**. 
+ **SSL verification**: activamos *Enable SSL verification*.
+ **Which events would you like to trigger this webhook?**: seleccionamos *Just the push event*.
+ Y por último, **y lo más importante**, marcamos la casilla: *Active*.

Guardamos los datos, y listo. Ahora solo tenemos que hacer un cambio en nuestro repositorio y esperar unos minutos a que **Github**, envie la notificación a **Packagist**.
