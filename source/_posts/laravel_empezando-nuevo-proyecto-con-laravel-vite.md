---
extends: _layouts.post
section: content
title: Nuevos proyectos Laravel con Vite, la alternativa a Webpack
date: 2022-07-10
updated: 2022-07-31
description: Laravel vite ha llegado para sustituir a Webpack, el sistema de gestión de assets para el front-end. Laravel vite es más rápido y moderno que su predecesor Webpack. Evan You el creador de VueJS ha desarrollado esta nueva herramienta que puede llegar a ser 100 veces más rápida que Webpack.
categories: [laravel, vite]
---

Hoy he empezado dos proyectos nuevos... la verdad es que a veces pienso que tengo que ir con mas calma. El caso es que he utilizado **la última versión de *Laravel*, e incluye la nueva librería Vite, en sustitución de WebPack**.

**Webpack** ha sido el gestor del *font-end* de **Laravel** desde hace años a través de **Laravel Mix**. Ahora ha sido sustituido por **Vite**, una alternativa más rápida y eficiente, desarrollada con un enfoque más moderno.

> **Evan You**, creador VueJS es el desarrollador de [Vite](https://vitejs.dev/){.link-out}.

**Laravel en su versión 9.19.0 ha integrado de forma nativa Vite**. Ya lo he probado, y tengo que admitir que efectivamente compila a una velocidad asombrosa, realmente es muy eficaz. Este cambio va a suponer dejar de lado **WebPack** y cambiar un poco la filosofía de funcionamiento del **framework**.

**Lo primero que me he encontrado ha sido un error en el certificado generado por Laravel Valet**. Personalmente utilizo **Valet** en mis proyectos, y en cuanto he ejecutado en el terminal `valet secure miProyecto`, y he ido la url `https://miproyecto.test` me han saltado varios errores con el certificado que ha generado **Valet**.

La configuración del fichero `vite.config.js` (en vez del fichero de WebPack), viene por defecto así:

```javascript
import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
 
export default defineConfig({
    plugins: [
        laravel([
            'resources/css/app.css',
            'resources/js/app.js',
        ]),
    ],
});
```

Desde la documentación oficial de **Laravel** proponen una solución para los errores del certificado generado por **Valet**:

```javascript
import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
 
export default defineConfig({
    plugins: [
        laravel([
            'resources/css/app.css',
            'resources/js/app.js',
        ]),
    ],
    server: { 
        https: true, 
        host: 'localhost', 
    }, 
});
```

Pero en la práctica no es una buena solución, ya que te salta un aviso de que no tienes certificado de seguridad y que tienes que aceptar el aviso del navegador de que estás accediendo a una web sin certificado. [Freek Van der Herten](https://freek.dev/2276-making-vite-and-valet-play-nice-together){.link-out} en su blog propone una solución mas elegante y sencilla:

```php
function detectServerConfig(host) {
    let keyPath = resolve(homedir(), `.config/valet/Certificates/${host}.key`)
    let certificatePath = resolve(homedir(), `.config/valet/Certificates/${host}.crt`)

    if (!fs.existsSync(keyPath)) {
        return {}
    }

    if (!fs.existsSync(certificatePath)) {
        return {}
    }

    return {
        hmr: {host},
        host,
        https: {
            key: fs.readFileSync(keyPath),
            cert: fs.readFileSync(certificatePath),
        },
    }
}
```

Es un método que verifica la existencia de los certificados generados por **Valet**, es decir, hace el trabajo sucio por ti, y el código final que he puesto en mi proyecto ha sido el siguiente:

```php
import fs from 'fs';
import laravel from 'laravel-vite-plugin'
import {defineConfig} from 'vite'
import {homedir} from 'os'
import {resolve} from 'path'

let host = 'miproyecto.test'

export default defineConfig({
    plugins: [
        laravel([
            'resources/css/app.css',
            'resources/js/app.js',
        ]),
    ],
    server: detectServerConfig(host),
});

function detectServerConfig(host) {
    let keyPath = resolve(homedir(), `.config/valet/Certificates/${host}.key`)
    let certificatePath = resolve(homedir(), `.config/valet/Certificates/${host}.crt`)

    if (!fs.existsSync(keyPath)) {
        return {}
    }

    if (!fs.existsSync(certificatePath)) {
        return {}
    }

    return {
        hmr: {host},
        host,
        https: {
            key: fs.readFileSync(keyPath),
            cert: fs.readFileSync(certificatePath),
        },
    }
}
```

Tengo que admitir que no estaba al tanto de esta situación, **y que he tenido que buscar en Google la solución**, y resulta que uno de los mas famosos programadores y divulgadores de **Laravel**, había posteado la solución al proglema en su blog. 

Por otro lado, si no quieres perder mucho tiempo con esto, la gente de [Laravelshift.com](https://laravelshift.com/convert-laravel-mix-to-vite){.link-out} ha creado **un convertidor gratuito** para pasar un proyecto de **Laravel Mix(Webpack)** a **Vite**.

**Laravel Vite también permite añadir funcionalidades nuevas**. En otro post diferente [Freek Van der Herten](https://freek.dev/2277-using-laravel-vite-to-automatically-refresh-your-browser-when-changing-a-blade-file){.link-out} propone un método para que las plantillas de **Blade** se refresquen automáticamente cuando se actualicen el código. Lo mismo que sucede con los *assets* cuando se actualiza algo y estas en modo `npm run watch`.

Para hacer esto, propone añadir el siguiente *plugin* al código:

```php
{
    name: 'blade',
    handleHotUpdate({ file, server }) {
        if (file.endsWith('.blade.php')) {
            server.ws.send({
                type: 'full-reload',
                path: '*',
            });
        }
    },
}
```

Ahora el archivo que he creado para mis proyectos, queda así:

```php
import fs from 'fs';
import laravel from 'laravel-vite-plugin'
import {defineConfig} from 'vite'
import {homedir} from 'os'
import {resolve} from 'path'

let host = 'miproyecto.test'

export default defineConfig({
    plugins: [
        laravel([
            'resources/css/app.css',
            'resources/js/app.js',
        ]),
        {
            name: 'blade',
            handleHotUpdate({ file, server }) {
                if (file.endsWith('.blade.php')) {
                    server.ws.send({
                        type: 'full-reload',
                        path: '*',
                    });
                }
            },
        }
    ],
    server: detectServerConfig(host),
});

function detectServerConfig(host) {
    let keyPath = resolve(homedir(), `.config/valet/Certificates/${host}.key`)
    let certificatePath = resolve(homedir(), `.config/valet/Certificates/${host}.crt`)

    if (!fs.existsSync(keyPath)) {
        return {}
    }

    if (!fs.existsSync(certificatePath)) {
        return {}
    }

    return {
        hmr: {host},
        host,
        https: {
            key: fs.readFileSync(keyPath),
            cert: fs.readFileSync(certificatePath),
        },
    }
}
```

Como apunte final, si en vez de utilizar [TailwindCss](https://tailwindcss.com/){.link-out} en tu proyecto, usas [Bootstrap](https://getbootstrap.com/){.link-out}, aquí tienes una guía de migración (en inglés):

- [https://creagia.com/blog/using-laravel-vite-with-bootstrap-and-sass](https://creagia.com/blog/using-laravel-vite-with-bootstrap-and-sass){.link-out}

En general es todo una gran mejora, pero sobre todo me ha gustado el plugin de [Freek Van der Herten](https://freek.dev/2277-using-laravel-vite-to-automatically-refresh-your-browser-when-changing-a-blade-file){.link-out} para actualizar en tiempo real los cambios en los archivos `.blade.php`, es espectacular ir modificando el código en una pantalla y ver el resultado en tiempo real en la otra. Una maravilla.

ACTUALIZACIÒN: Laravel Vite ahora es capaz de refrescar de forma nativa las modificaciones en blade, según comenta en:

- [https://laravel-news.com/laravel-blade-hot-refresh-with-vite](https://laravel-news.com/laravel-blade-hot-refresh-with-vite){.link-out}