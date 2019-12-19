---
extends: _layouts.post
section: content
title: Creando enlaces externos con Javascript de forma dinámica
date: 2019-12-07
description: Enlaces externos con vanilla javascript, de forma dinámica y markdown como formato de texto
categories: [javascript, markdown]
---

En ocasiones, nos encontramos en la situación en la que necesitamos generar enlaces externos de forma dinámica. Por ejemplo, pensemos en un código `markdown`, en el que queremos que nuestro enlace tenga el attributo `target`, con el valor *_blank*.

La forma más sencilla de hacerlo, es añadiendo a nuestro enlace una clase `css`(siempre que tengamos la versión extendida de `markdown`):

```html 
[Laravel](https://laravel.com/){.link-out}
```

Con `markdown`, podemos añadir attributos con los corchetes:

```html 
[Laravel](https://laravel.com/){#myID .link-out}
```

Que se renderizará en:

```html 
<a href="https://laravel.com/" id="myID" class="link-out">Laravel</a>
```

Ahora, solo tenemos que añadir un poco de código `javascript` en nuestra página:

```javascript
<script>
    document.addEventListener('DOMContentLoaded', function() {
        var linksTargetBlank = document.querySelectorAll('.link-out');
        for (var i = 0; i < linksTargetBlank.length; i++) {
            linksTargetBlank[i].target = "_blank";
        }
    }, false);
</script>
```

Automáticamente, una vez que se cargue la página, añadirá el atritudo `target` con el valor *_blank*, a todos los enlaces con la clase *.link-out*.
