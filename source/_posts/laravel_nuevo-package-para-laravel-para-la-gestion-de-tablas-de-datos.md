---
extends: _layouts.post
section: content
title: Package para Laravel, para la gestión de Tablas de Datos
date: 2021-04-17
description: Nuevo package para la gestión de Tablas de Datos (Tipo DataTables) usando Laravel, Livewire, AlpinJS y TailwindCSS. Una versión del famoso DataTables usando librerías más modernas y mucho más ligero.
categories: [alpinejs, laravel, Livewire, packages, packagist, php]
---

Hace algún tiempo, me plantee el reto de desarrollar un sistema de administración igual que **Laravel Nova**, pero sin usar `Vuejs`, una autentica locura de la que aprendí muchísimo.

Esta idea loca, se debía a dos situaciones diferentes: por un lado, buscaba mejorar mis habilidades como programador sumergiéndome en un proyecto de este calibre, y por otro lado, por aquel entonces odiaba (de forma inexplicable) `vueJS`, y necesitaba una alternativa que no utilizara este `framework`. La solución fue escribir todo utilizando solo *vanilla `javascript`*.

Esta experiencia me llevó a entender mejor el funcionamiento de `javascript` como lenguaje y a [terminar por apreciarlo](https://daguilar.dev/blog/javascript_mis-problemas-con-javascript/). 

Después de aquello, me planteé hacer una segunda versión del proyecto, pero basado en `Livewire`, `AlpineJS` y `TailwindCSS`, y después de varias semanas trabajando en él, me di cuenta que tal vez sería más interesante dividir el proyecto en varios packages independientes, y que **Belich**, fuera más bien un entorno de desarrollo donde se utilizaban en conjunto todos estos packages.

Cuento todo esto, porque ya se puede utilizar el primer `package` que he desarrollado. Se llama: **Belich Tables**.

![Belich Tables desarrollado con Livewire](/assets/img/projects/belich-tables.png)

Todo empezó cuando decidí empezar a desarrollar el sistema de *tablas de datos*, emulando a [datatables](https://datatables.net/){.link-out}, y en el camino me encontré un package que a primera vista funcionaba muy bien:

- [https://github.com/rappasoft/laravel-livewire-tables](https://github.com/rappasoft/laravel-livewire-tables){.link-out}

La verdad es que ofrecía una estructura básica muy interesante, pero vi que puediera llegar hasta donde yo necesitaba para poder integrarlo en el proyecto, por lo que procedí a crear un **fork** en `github` y empecé a añadir mejoras:

- El código se ha rediseñado desde prácticamente 0, mejorando la estructura y el rendimiento.
- Se ha dado soporte para `TailwindCSS`, ya que estaba diseñado para ser utilizado con `Bootstrap`.
- Se ha integrado un sistema de mensajes, utilizando la funcionalidad de *flash messages* the `Livewire`.
- Implementación de los campos de accion en la tabla, de forma que se pudieran: *editar, mostrar y eliminar campos*.
- Filtrado de resultados por columnas, utilizando un sistema similar a **Laravel Nova**.
- Se ha cambiado la paginación por una paginación simple.
- Se han añadido `checkboxes` para seleccionar filas y realizar acciones masivas sobre los elementos seleccionados.
- Se ha habilitado un sistema que permite configurar y personalizar estas acciones masivas.
- Se ha mejorado la personalización y adaptabilidad del `package` a cualquier proyecto.
- Se ha desarrollado una documentación completa sobre su funcionamiento.

Y muchas más funcionalidades menores, que han añadido al `package` mucha mayor flexibilidad y adaptabilidad.

Puedes ver el `package` en: 

- [https://github.com/daguilarm/belich-tables](https://github.com/daguilarm/belich-tables){.link-out}

Y su documentación en:

- [https://daguilarm.github.io/belich-tables/](https://daguilarm.github.io/belich-tables/){.link-out}
