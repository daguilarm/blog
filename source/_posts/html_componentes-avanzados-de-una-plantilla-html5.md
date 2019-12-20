---
extends: _layouts.post
section: content
title: Creando una plantilla HTML5 avanzada
date: 2019-12-20
description: Diseño y componentes avanzados para una plantilla HTML
categories: [html5]
---

Una plantilla básica HTML5, tendría el siguiente aspecto

```html
<!DOCTYPE html>
<html lang="es">
  <head>
    <meta charset="utf-8" />
    <meta http-equiv="x-ua-compatible" content="ie=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />

    <title></title>

    <link rel="stylesheet" href="css/main.css" />
    <link rel="icon" href="images/favicon.png" />
  </head>

  <body>
    <script src="js/scripts.js"></script>
  </body>
</html>
```

## Meta-etiquetas 

Lo primero será añadir las meta-etiquetas *description* y *keywords* en el `<head>` del documento `HTML`:

```html
<meta name="description" content="">
<meta name="keywords" content="">
```

Seguido de la etiqueta *theme-color*, utilizada por los dispositivos **Android** para definir el color base:

```html
<meta name="theme-color" content="#fafafa">
```

Si utilizamos **Laravel**:

```html
<meta name="csrf-token" content="{{ csrf_token() }}">
```

Y toda una seríe de configuraciones por defecto:

```html
<meta name="copyright"content="Your name or company name">
<meta name="language" content="Your language">
<meta name="url" content="Your URL">
<meta name="identifier-URL" content="Your URL">
<meta name="directory" content="submission">
<meta name="category" content="">
<meta name="robots" content="index, follow">
<meta name="coverage" content="Worldwide">
<meta name="distribution" content="Global">
<meta name="rating" content="General">
<meta name="revisit-after" content="7 days">
<meta http-equiv="Expires" content="0">
<meta http-equiv="Pragma" content="no-cache">
<meta http-equiv="Cache-Control" content="no-cache">
<meta name="revised" content="Sunday, July 18th, 2010, 5:15 pm" />
```

También podemos añadir etiquetas personalizadas de algunos servicios:

```html
<!-- Custom tags -->
<meta name="google-analytics" content=""/>
<meta name="disqus" content=""/>
```

Nuestros iconos:

```html
<!-- Icons -->
<link rel="shortcut icon" href="/favicons/favicon.ico">
<link rel="icon" type="image/png" sizes="32x32" href="/favicons/favicon-32x32.png">
<link rel="icon" type="image/png" sizes="16x16" href="/favicons/favicon-16x16.png">
```

Las etiquetas para dispositivos *Apple*:

```html
<!-- Apple -->
<meta name="apple-mobile-web-app-capable" content="yes">
<meta content="yes" name="apple-touch-fullscreen" />
<meta name="apple-mobile-web-app-status-bar-style" content="black">
<meta name="format-detection" content="telephone=no">
<meta name="apple-mobile-web-app-title" content="My Site">
<link rel="apple-touch-icon" sizes="180x180" href="/favicons/apple-touch-icon.png">
<link rel="mask-icon" href="/favicons/safari-pinned-tab.svg" color="grey">
```

Las etiquetas de microsoft 

```html
<!-- Microsoft -->
<meta name="msapplication-TileColor" content="grey">
<meta name="msapplication-config" content="/favicons/browserconfig.xml">
```

Un ejemplo del `browserconfig.xml`:

```bash
<? xml version = "1.0" encoding = "utf-8" ?>
  <browserconfig>
    <msapplication>
      <tile>
        <square150x150logo src="/favicons/mstile-150x150.png" />
        <TileColor>grey</TileColor>
      </tile>
    </msapplication>
  </browserconfig>
```

Incluye un `manifest` y la etiqueta `application-name` entre tus metatags:

```html
<link rel="manifest" href="site.webmanifest">
<meta name="application-name" content="My Site">
```

Un ejemplo del `site.webmanifest`:

```javascript
{
  "name": "My Website",
  "short_name": "My Site",
  "icons": [
    {
      "src": "/favicons/android-chrome-192x192.png",
      "sizes": "192x192",
      "type": "image/png"
    },
    {
      "src": "/favicons/android-chrome-384x384.png",
      "sizes": "384x384",
      "type": "image/png"
    }
  ],
  "theme_color": "#ffffff",
  "background_color": "#ffffff"
}
```

## Librerías externas css y fuentes

Si vamos a utilizar [Google fonts](https://fonts.google.com){.link-out} o librerías externas **CSS**, es buena idea utilizar:

```html
<link rel="dns-prefetch" href="//fonts.googleapis.com">
<link rel="preconnect" href="//fonts.googleapis.com" crossorigin>
<link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,800,800i,900,900i" rel="stylesheet" media="all">
```

+ **dns-prefetch**: notifica al navegador que debería resolver el DNS de un dominio específico antes de que este sea llamado explícitamente.
+ **preconnect**: informa al navegador que vamos a establecer una conexión con un dominio externo, y que queremos hacerlo lo antes posible.

## Body 

Idiquemos que no se soportan navegadores prehistóricos:

```html
<!--[if IE]>
    <p class="browserupgrade">You are using an <strong>outdated</strong> browser. Please <a href="https://browsehappy.com/">upgrade your browser</a> to improve your experience and security.</p>
<![endif]-->
```

Añadamos las etiquetas básicas para crear el cuerpo de nuestra plantilla:

```html
<header>
    <!-- My header code -->
</header>

    <div id="app">
        <!-- My application code -->
    </div>

<footer>
    <!-- My footer code -->
</footer>
```

Pongamos el código `javascript` al final del código, y si vamos a utilizar librerías como por ejemplo: **Jquery**, utilicemos un CDN usando la misma técnica que con las **Google Fonts**:

```html
<!-- Javascript code -->
<link rel="dns-prefetch" href="//code.jquery.com">
<link rel="preconnect" href="//code.jquery.com" crossorigin>
<script src="https://code.jquery.com/jquery-{{JQUERY_VERSION}}.min.js" integrity="{{JQUERY_SRI_HASH}}" crossorigin="anonymous"></script>
```

Si queremos usar el código de google-analytics:

```html
<!-- Google Analytics: change UA-XXXXX-Y to be your site's ID. -->
<script>
window.ga = function () { ga.q.push(arguments) }; ga.q = []; ga.l = +new Date;
ga('create', 'UA-XXXXX-Y', 'auto'); ga('set','transport','beacon'); ga('send', 'pageview')
</script>
<script src="https://www.google-analytics.com/analytics.js" async></script>
```

## Resumen

Poniendo todo lo anterior junto:

```html
<!DOCTYPE html>
<html lang="es">
  <head>
    <meta charset="utf-8" />
    <meta http-equiv="x-ua-compatible" content="ie=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <meta name="theme-color" content="#ffffff">
    
    <!-- Only with Laravel -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <!-- Only with Laravel -->

    <meta name="robots" content="index, follow">
    <meta name="copyright"content="">
    <meta name="language" content="">
    <meta name="url" content="">
    <meta name="identifier-URL" content="">
    <meta name="directory" content="submission">
    <meta name="category" content="">
    <meta name="coverage" content="Worldwide">
    <meta name="distribution" content="Global">
    <meta name="rating" content="General">
    <meta name="revisit-after" content="7 days">
    <meta http-equiv="Expires" content="0">
    <meta http-equiv="Pragma" content="no-cache">
    <meta http-equiv="Cache-Control" content="no-cache">
    <meta name="revised" content="Sunday, July 18th, 2010, 5:15 pm" />

    <!-- Icons -->
    <link rel="shortcut icon" href="/favicons/favicon.ico">
    <link rel="icon" type="image/png" sizes="32x32" href="/favicons/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="16x16" href="/favicons/favicon-16x16.png">

    <!-- Apple -->
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta content="yes" name="apple-touch-fullscreen" />
    <meta name="apple-mobile-web-app-status-bar-style" content="black">
    <meta name="format-detection" content="telephone=no">
    <meta name="apple-mobile-web-app-title" content="My Site">
    <link rel="apple-touch-icon" sizes="180x180" href="/favicons/apple-touch-icon.png">
    <link rel="mask-icon" href="/favicons/safari-pinned-tab.svg" color="grey">

    <!-- Microsoft -->
    <meta name="msapplication-TileColor" content="grey">
    <meta name="msapplication-config" content="/favicons/browserconfig.xml">

    <!-- Site information -->
    <title></title>
    <meta name="description" content="">
    <meta name="keywords" content="">

    <!-- Load external CDN -->
    <link rel="dns-prefetch" href="//fonts.googleapis.com">
    <link rel="preconnect" href="//fonts.googleapis.com" crossorigin>
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,800,800i,900,900i" rel="stylesheet" media="all">
    
    <link rel="stylesheet" href="css/main.css" />
    <link rel="icon" href="images/favicon.png" />

    <link rel="manifest" href="site.webmanifest">
    <meta name="application-name" content="">

  </head>

  <body>
    <!--[if IE]>
        <p class="browserupgrade">You are using an <strong>outdated</strong> browser. Please <a href="https://browsehappy.com/">upgrade your browser</a> to improve your experience and security.</p>
    <![endif]-->
    <header>
        <!-- My header code -->
    </header>

        <div id="app">
            <!-- My application code -->
        </div>

    <footer>
        <!-- My footer code -->
    </footer>

    <!-- Javascript code -->
    <link rel="dns-prefetch" href="//code.jquery.com">
    <link rel="preconnect" href="//code.jquery.com" crossorigin>
    <script src="https://code.jquery.com/jquery-{{JQUERY_VERSION}}.min.js" integrity="{{JQUERY_SRI_HASH}}" crossorigin="anonymous"></script>
    <script src="js/scripts.js"></script>

    <!-- Google Analytics: change UA-XXXXX-Y to be your site's ID. -->
    <script>
    window.ga = function () { ga.q.push(arguments) }; ga.q = []; ga.l = +new Date;
    ga('create', 'UA-XXXXX-Y', 'auto'); ga('set','transport','beacon'); ga('send', 'pageview')
    </script>
    <script src="https://www.google-analytics.com/analytics.js" async></script>
  </body>
</html>
```

Mas información:

+ https://html5boilerplate.com/
+ http://www.initializr.com/
+ https://developers.google.com/web/fundamentals/performance/resource-prioritization?hl=es
+ https://developers.google.com/web/updates/2015/08/using-manifest-to-set-sitewide-theme-color
+ https://www.chromium.org/developers/design-documents/dns-prefetching
