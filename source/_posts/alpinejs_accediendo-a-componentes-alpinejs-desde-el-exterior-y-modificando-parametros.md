---
extends: _layouts.post
section: content
title: Accediendo a componentes AlpineJS desde el exterior de estos, mientras modificamos sus atributos y propiedades
date: 2020-11-02
description: En este artículo se muestra como acceder a componentes AlpineJS desde fuera de ellos, a la vez que se es capaz de modificar sus propiedades desde fuera
categories: [javascript, alpinejs]
---

Me he encontrado en la situación de tener que cambiar un componente `AlpineJS desde otro componente, veamos un ejemplo de la situación:

```html 
<div x-data="component_1()" id="component_1">
    <div x-text="text_1"></div>
</div>   

<div x-data="component_2()" id="component_2">
    <div x-text="text_2"></div>
</div>  

<script>
    function component_1() {
        return {
            text_1: 'texto 1',
        }
    }
    function component_2() {
        return {
            text_2: text_1 + ' junto con texto 2',
        }
    }
</script> 
```

Para acceder a la información de un componente de `AlpineJS`, se puede hacer así:

```javascript 
    var component_1 = document.getElementById('component_1');
    console.log(component_1.__x.getUnobservedData().text_1)
```

Mediante `component_1.__x.getUnobservedData()` accedemos a todos los datos del componente 1. Esto es debido a que toda la información se guarda en el `DOM` y por tanto se puede acceder a ella en cualquier momento.

Si por otro lado, lo que queremos es acceder a los datos y poder modificarlos, debemos hacerlo así:

```javascript 
    var component_1 = document.getElementById('component_1');
    component_1.__x.$data.text_1 = 'nuevo texto...';
```

Me he pasado un par de horas investigando en el código de `AlpineJS` y aunque ha sido un poco denso..., he aprendido algunas cosas sobre como funciona el código interno de `AlpineJS`. Por si teneis curiosidad, básicamente he estado detrás de un componente basado en `datalist` de `HTML5`, pero con la flexibilidad de `AlpineJS`, porque vamos a ser francos, los elementos `datalist` son una mierda.
