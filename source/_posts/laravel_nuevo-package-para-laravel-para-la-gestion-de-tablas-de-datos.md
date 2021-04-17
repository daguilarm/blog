---
extends: _layouts.post
section: content
title: Nuevo package para Laravel, para la gestión de Tablas de Datos
date: 2021-04-17
description: Package para la gestión de Tablas de Datos usando Laravel, Livewire, AlpinJS y TailwindCSS.
categories: [alpinejs, laravel, Livewire, packages, packagist, php]
---

Hace algún tiempo, me plantee el reto de desarrollar un sistema de administración igual que **Laravel Nova**, pero sin usar `Vuejs`, lo llamé **Belich**. 

Esta idea loca, se debía a dos situaciones diferentes: por un lado, buscaba mejorar mis habilidades como programador sumergiéndome en un proyecto de este calibre, y por otro lado, por aquel entonces odiaba (de forma inexplicable) `vueJS`, y necesitaba una alternativa que no utilizara este `framework`. La solución fue escribir todo utilizando solo *vanilla `javascript`*.

Esta experiencia me llevó a entender mejor el funcionamiento de `javascript` como lenguaje y a [terminar por apreciarlo](https://daguilar.dev/blog/javascript_mis-problemas-con-javascript/). 

Después de aquello, me planteé hacer una segunda versión del proyecto, pero basado en `Livewire`, `AlpineJS` y `TailwindCSS`, y después de varias semanas trabajando en él, me di cuenta que tal vez sería más interesante dividir el proyecto en varios packages independientes, y que **Belich**, fuera más bien un entorno de desarrollo donde se utilizaban en conjunto todos estos packages.

Cuento todo esto, porque ya se puede utilizar el primer `package` que he desarrollado. Se llama: **Livewire Tables**.

![Livewire tables](/assets/img/projects/livewire-tables.png)

Todo empezó cuando decidí empezar a desarrollar el sistema de *tablas de datos*, emulando a [datatables](https://datatables.net/){.link-out}, y en el camino me encontré un package que a primera vista funcionaba muy bien:

- [https://github.com/rappasoft/laravel-livewire-tables](https://github.com/rappasoft/laravel-livewire-tables){.link-out}

La verdad es que ofrecía una estructura básica muy interesante, pero vi en seguida sus limitaciones, y tras indagar un poco, vi que no había mucho interés por parte del creador por evolucionar y mejorar el `package`, por lo que procedí a crear un **fork** en `github` y empecé a añadir mejoras:

- Lo primero fue dar soporte para `TailwindCSS`, ya que estaba diseñado para `Bootstrap.
- Integrar un sistema de mensajes, utilizando la funcionalidad de *flash messages* the `Livewire`.
- Añadir los campos de accion a la tabla, de forma que se pudieran: *editar, mostrar y eliminar los campos*.
- Permitir filtrar los resultados por columnas, utilizando un sistema similar a **Laravel Nova**.
- Cambiar la paginación por una paginación simple.
- Añadir `checkboxes` para seleccionar filas y realizar acciones masivas con los elementos seleccionados.
- Habilitar un sistema que permita configurar estas acciones masivas.

Y muchas más funcionalidades menores, que han añadido al `package` mucha mayor flexibilidad.

Puedes ver el `package` en: 

- [https://github.com/daguilarm/livewire-tables](https://github.com/daguilarm/livewire-tables){.link-out}
