---
extends: _layouts.post
section: content
title: Migrando el blog a Jigsaw
date: 2019-11-07
description: Actualizando el blog a Jigsaw, el framework para desarrollo de sitios estáticos 
categories: [blade, frameworks, php]
---

En 2015, empecé mi primer blog sobre programación. Fue en otro dominio, y con un **CMS**, que en aquel momento, me parecía una buena opción: [AnchorCMS](https://anchorcms.com/){.link-out}. No tardé mucho en cansarme de sus limitaciones, y empecé a modificarlo, y modificarlo, y terminó siendo algo totalmente distinto, y durante algún tiempo funcionó. 

Fue entonces cuando descubrí [Laravel](https://laravel.com){.link-out}, y decidí crear mi propio CMS. Durante los años, llegué a realizar dos desarrollos diferentes del blog, y al final, terminé por cansarme.

No fue hasta hace unos meses, cuando empecé a trastear con *frameworks* de desarrollo para sitios estáticos. 

Mi primer encuentro con el mundo estático, fue con [Vuepress](https://vuepress.vuejs.org/){.link-out}, y la verdad es que no me gustó nada... ultimamente, cada vez me gusta menos [Vuejs](https://vuejs.org/){.link-out}, y después de este, probé algún que otro *frameworks* mas, pero ninguno de ellos terminaron por convencerme demasiado. 

Había desistido, hasta que un artículo sobre [Jigsaw](https://jigsaw.tighten.co/){.link-out}, cayó en mis manos, y me decidí a probarlo... pasé una mañana de Sábado realizando las primeras pruebas, y aquello me gusto, era exáctamente lo que estaba buscando, y empecé a trabajar en el nuevo blog.

**A favor**:

* Es un sistema basado en `php`, sigo sintiéndome mucho más cómodo aquí.
* Utiliza **Blade** como gestor de plantillas... una maravilla, cuando llevas tanto tiempo trabajando con **Laravel**.
* [Tailwindcss](https://tailwindcss.com/){.link-out} como framework css. Ahora mismo, me parece imprescindible.
* Compatible con [Netlify](https://www.netlify.com/){.link-out}, permitiendo *deploy* en tiempo real, desde [Github](https://github.com/){.link-out}.
* *Markdown* como formato de archivos.
* Busqueda con [Angolia](https://www.algolia.com/){.link-out} integrada.
* Desarrollo muy rápido.

**En contra**:

* Solo para programadores, ya que no dispone de un panel de administración para gestionar el sistema, no es un **CMS**.

Si lo que buscas es un **CMS** con panel de administrador, aquí tienes algunas opciones: 

* [Wink](https://wink.themsaid.com/){.link-out} 
* [Wordpress](https://es.wordpress.com/){.link-out}
