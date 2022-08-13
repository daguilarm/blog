---
extends: _layouts.post
section: content
title: Configurar dominios en un hosting de Digitalocean
date: 2022-08-13
description: Configurar las DNS de un dominio comprado en Google Domains en el proveedor de alojamiento web Digitalocean. Configuración de los diferentes DNS que hay que crear y distribuir.
categories: [servidores]
---

[Digitalocean](https://m.do.co/c/507d909fac29){.link-out}, Linode, Amazon AWS, Hetzner y Vultr son algunos de los proveedores de servidores en la nube más utilizados. Estos sistemas virtualizados, te proporcionan toda la infraestructura necesaria para desplegar tu proyecto dandote acceso a bases de datos, discos duros, hardware, etc... En resumen, estos servicios se denominan IaaS (Infraestructura como servicio) y te ofrecen una versatilidad enorme a la hora de configurar tu proyecto, pudiendo aumentar memoria, capacidad de disco duro, o balancear la carga del servidor según las necesidades puntuales de tu proyecto.

Estos son uno de los motivos que me han llevado a utilizar [Digitalocean](https://m.do.co/c/507d909fac29){.link-out} como proveedor en la nube para mis proyectos (salvo este blog, que está alojado en [Netlify](https://www.netlify.com/){.link-out}, servicio espectacular para sitios estáticos sin bases de datos). 

Uno de los principales motivos ha sido el que para gestionar los servidores de mis proyectos utilizo [Laravel Forge](https://forge.laravel.com/){.link-out} y entre los servidores que soporta está [Digitalocean](https://m.do.co/c/507d909fac29){.link-out}.

> El otro motivo, es que [te regalan 100$ para empezar a usar sus servidores](https://m.do.co/c/507d909fac29){.link-out}... nada mal, y también > es cierto que hay muchos tutoriales sobre esta plataforma, que al final, te animan a utilizarla.

## Configurar el dominio con las DNS de Digitalocean 

Lo primero es ir a nuestro proveedor de dominios y en la sección de DNS añadir las de [Digitalocean](https://m.do.co/c/507d909fac29){.link-out}:

- NS1.DIGITALOCEAN.COM
- NS2.DIGITALOCEAN.COM
- NS3.DIGITALOCEAN.COM

Guardamos, y ahora tendremos que esperar entre 12h y 48h a que se propaguen las DNS por todo internet... lo normal es que tarden menos de 24 horas, pero a veces se complica, y lo digo por experiencia. Mi último proyecto ha tardado casi 48 horas en estar disponible.

## Ir al panel de administración de Digitalocean

Lo primero que tienes que hacer es ir a tu servidor (Droplets) e ir a la sección de dominios. Una vez allí, le das a crear uno nuevo, y entonces ya podemos configurar las DNS.

![Nuevo dominio](../../../assets/img/posts/dns/new-domain.png){.thumbnail}

Primero hay que añadir un registro de tipo A, para ello en el campo `HOSTNAME`, añadimos `@` y en el campo `WILL DIRECT TO` seleccionamos en el desplegable el servidor en el que queremos añadir el dominio. Y ahora pulsamos en `Create Record`.

![DNS Records A](../../../assets/img/posts/dns/a-record.png){.thumbnail}

Lo siguiente será crear un registro tipo `CNAME`. En el campo `HOSTNAME` añadimos `www` y en el campo `IS AN ALIAS OF` añadimo `@`. Y ahora pulsamos en `Create Record`.

![DNS Records A](../../../assets/img/posts/dns/cname-record.png){.thumbnail}

Ahora tenemos que añadir otro registro `CNAME`, esta vez para añadir la opción de *wildcard*, para ello, en el campo `HOSTNAME` añadimos `*` y en el campo `IS AN ALIAS OF` añadimo `@`. Y volvemos a pulsar en `Create Record`.

![DNS Records Wildcard](../../../assets/img/posts/dns/wildcard-record.png){.thumbnail}

Y por último, nos quedaría una configuración como esta:

![DNS Configuración final](../../../assets/img/posts/dns/final.png){.thumbnail}

#### Fuentes:

- [https://www.redhat.com/es/topics/cloud-computing/what-are-cloud-providers](https://www.redhat.com/es/topics/cloud-computing/what-are-cloud-providers){.link-out}
- [https://www.ambit-bst.com/blog/definici%C3%B3n-de-iaas-paas-y-saas-en-qu%C3%A9-se-diferencian](https://www.ambit-bst.com/blog/definici%C3%B3n-de-iaas-paas-y-saas-en-qu%C3%A9-se-diferencian){.link-out}
- [https://serverpilot.io/docs/how-to-configure-dns-on-digitalocean/](https://serverpilot.io/docs/how-to-configure-dns-on-digitalocean/){.link-out}
- [https://stackoverflow.com/questions/55808188/how-to-setup-dns-configuration-with-netlify-and-digital-ocean-combined](https://stackoverflow.com/questions/55808188/how-to-setup-dns-configuration-with-netlify-and-digital-ocean-combined){.link-out}