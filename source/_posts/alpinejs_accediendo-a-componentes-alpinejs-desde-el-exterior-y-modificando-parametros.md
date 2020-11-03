---
extends: _layouts.post
section: content
title: Accediendo a componentes AlpineJS desde el exterior de estos, mientras modificamos sus atributos y propiedades
date: 2020-11-02
description: En este artículo se muestra como acceder a componentes AlpineJS desde fuera de ellos, a la vez que se es capaz de modificar sus propiedades desde fuera
categories: [javascript, alpinejs]
---

Me he encontrado en la situación de tener que cambiar un componente `AlpineJS`desde otro componente, veamos un ejemplo de la situación:

```html 
<div x-data="component_1()" id="component_1">
    <div x-text="text_1"></div>
</div>   

<div x-data="component_2()" id="component_2">
    <div x-text="text_2"></div>
</div>  
```

Y el código `JavaScript`:

```javascript 
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
```

Todo junto:

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

Mediante `__x.getUnobservedData()` accedemos a todos los datos del componente 1. Esto es debido a que toda la información se guarda en los `DOM nodes` y por tanto se puede acceder a ella en cualquier momento mediante la propiedad `__x.$data` a la cual puedemos acceder mediante el método `getUnobservedData()`.

Si por otro lado, lo que queremos es acceder a los datos y poder modificarlos, debemos hacerlo directamente mediante `__x.$data`:

```javascript 
    var component_1 = document.getElementById('component_1');
    component_1.__x.$data.text_1 = 'nuevo texto...';
```

Al final he llegado a este este artículo:

+ [https://codewithhugo.com/alpinejs-inspect-component-data-from-js/](https://codewithhugo.com/alpinejs-inspect-component-data-from-js/){.link-out}

A partir de este artículo, he sentido curiosidad y me he ido al código fuente de `AlpineJS`, donde me he pasado un buen rato dándole vueltas y viendo como funciona. Ha sido bastante denso, creo que ha merecido la pena ver su funcionamiento interno (o intuirlo, porque me he perdido en muchas ocasiones).

En el artículo también me he encontrado con una herramienta para desarrolladores para trabajar con `AlpineJS` y que se integra tanto en `Chrome` como en `Firefox`:

+ [https://github.com/amaelftah/alpinejs-devtools](https://github.com/amaelftah/alpinejs-devtools){.link-out}
