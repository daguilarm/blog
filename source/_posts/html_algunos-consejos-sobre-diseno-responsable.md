---
extends: _layouts.post
section: content
title: Algunos consejos sobre diseño responsable (responsive design)
date: 2020-10-08
description: Diseño de una web adaptable a los diferentes dispositivos
categories: [html]
---

Cuando se empieza un proyecto hay siempre que tener en cuenta dos aspectos: la usabilidad y el diseño responsable adaptado a todos los dispositivos. Esto en general es lo correcto, pero también puede llegar a convertirse en una pesadilla, sobre todo conel diseño responsable.

Desde mi punto de vista, y seguramente estoy equivocado, creo que la mejor estrategia para afrontar un desarrollo web es centrando el proyecto en dos componentes diferenciados, por un lado el diseño de una app para teléfono móvil y por el otro, el diseño de una web responsable que se adapte al resto de dispositivos. 

Creo que la idea de que un web sirva para móviles, tablets, portátiles y ordenadores de sobremesa es una locura y que termina absorviendo demasiado tiempo (a veces inútil). Mi planteamiento es simple, consiste en centrarse en los dispositivos de un tamaño aceptable y que permiten la experiencia completa de una web, como son el: tablet, el portatil y ordenador de sobremesa. Y para el teléfono móvil, centrarnos en el desarrollo de una aplicación para móvil o directamente una web pensada exclusivamente para las limitaciones de espacio de este dispositivo, es decir, hay que hacer un desarrollo exclusivo para móviles. 

Vamos a ver, ya que hay que ponerse a desarrollar estilos propios para un teléfono móvil, y que seguramente esto va a terminar convirtiéndose una hoja de estilos independiente, lo mejor es hacerlo bien y en vez de adaptar el proyecto al dispositivo, centrarse en desarrollar un poryecto propio para el dispositivo. Al final se va a tardar lo mismo y el resultado va a ser mucho mejor.

Personalmente, para el desarrollo de aplicaciones estoy utilizando [ElectronJS](https://www.electronjs.org/){.link-out}, pero supongo que existen varias alternativas para el desarrollo de apps multi-dispositivo. En internet vas a encontrar muchos tutoriales y cursos sobre el tema.

Respecto a la web multidispositivo... el primer problema que te vas a encontrar es el tema de los comportamientos ante eventos como por ejemplo cuando en tu código HTML introduces un evento CSS tipo `:hover`. Esto es un problema serio, ya que un tablet no dispone de esta opción, y por tanto, si nuestro menú de navegación funciona así, el usuario va a tener un problema importante. Veamos un ejemplo:

```html
<style>
  .dropdown {
    position: relative;
    display: inline-block;
  }

  .dropdown-content {
    display: none;
    position: absolute;
    min-width: 200px;
    z-index: 50;
  }

  .dropdown:hover .dropdown-content {
    display: block;
  }
</style>

<div class="dropdown">
  <span>Desplegable</span>
  <div class="dropdown-content">
    <p>Contenido del desplegable</p>
  </div>
</div>
```

La solución a este problema es bastante sencilla, pero me llevó bastante tiempo dar con la solución correcta (al menos para mi). Mi idea era buscar una opción que no me obligara a ir duplicando el código CSS para tablets (este ha sido el motivo principal para dividir el proyecto en una web y una app), y para ello encontré un artículo de Mezo Istvan sobre el tema [Finally, a CSS only solution to :hover on touchscreens](https://medium.com/@mezoistvan/finally-a-css-only-solution-to-hover-on-touchscreens-c498af39c31c){.link-out}

En él plantea la idea de utilizar los *media queries* para no tener que repetir código. Partamos del código del ejemplo anterior y uticemos los *media queries* para hacerlo funcionar en un tablet:


```html
<style>
  .dropdown {
    position: relative;
    display: inline-block;
  }

  .dropdown-content {
    display: none;
    position: absolute;
    min-width: 200px;
    z-index: 50;
  }

  @media(hover: hover) and (pointer: fine) {
    .dropdown:hover .dropdown-content {
      display: block;
    }
  }
</style>

<div class="dropdown">
  <span>Desplegable</span>
  <div class="dropdown-content">
    <p>Contenido del desplegable</p>
  </div>
</div>
```

Ahora cuando un tablet haga click sobre un evento `:hover`, funcionará sin problemas. Tiene la limitación de que si utilizamos sistemas como [Bootstrap](https://getbootstrap.com/){.link-out} o [Tailwind](https://tailwindcss.com/){.link-out} vamos a tener que hacer nuestra propia hoja de estilos, pero en cualquier caso a mi me parece una buena solución.

Para finalizar, creo que hay que tener en cuenta algunas cuestiones sobre el tema: 

- Evitar los eventos `:hover` en lo posible en el web. Yo personalmente me limito a la barra de navegación y utilizo esta técnica. 
- Si utilizamos enlaces para el efecto `:hover` hay que evitar que tengan respuesta, es decir, un enlace `<a href="#">enlace</a>` no funcionará con la técnica de los *media queries*, tendríamos que cambiarlo por esto otro `<a href="javascript:void(0)">enlace</a>`. 
- Eliminar de la versión para tablet todas aquellas partes que sea prescindibles, tenemos menos espacio y hay que mostrar solo lo necesario.
- El tamaño de fuentes, y sobre todo **iconos**, debe de ser mayor en la versión para tablet. **Es muy importante que los iconos sean grandes** para evitar al usuario tenga que pasar media hora intentando entrar en una sección.

Mas información:

+ https://developer.mozilla.org/es/docs/CSS/Media_queries
