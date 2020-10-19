---
extends: _layouts.post
section: content
title: Librería para mapas LeafletJS
date: 2020-10-20
description: Utilización de la librería JavaScript LeafletJS para la creación de mapas a través de servicios WMS.
categories: [javascript, livewire, alpinejs]
---

Según wikipedia<sup>1</sup> un servicio WMS produce mapas de datos referenciados espacialmente, de forma dinámica a partir de información geográfica. Es decir, estamos hablando de servicios como GoogleMaps, OpenStreetMap o similares. Es decir, capas de información que se muestran superpuestas y en forma de mapa.

Podemos integrar estos servicios en nuestro proyecto web, mediante la librería [LeafletJS](https://leafletjs.com/){.link-out}

Lo primero que tenemos que hacer es instalarla en nuestro proyecto. En el `<head>` de nuestra web, añadimos el código `css` y `JavaScript`:

```html 
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.7.1/dist/leaflet.css"
   integrity="sha512-xodZBNTC5n17Xt2atTPuE1HxjVMSvLVW9ocqUKLsCC5CXdbqCmblAshOMAS6/keqq/sMZMZ19scR4PsZChSR7A=="
   crossorigin=""/>
<!-- Make sure you put this AFTER Leaflet's CSS -->
<script src="https://unpkg.com/leaflet@1.7.1/dist/leaflet.js"
  integrity="sha512-XQoYMqMTK8LvdxXYG3nZ448hOEQiglfqkJs1NOQV44cWnUrBc8PkAOcXy20w0vlaXaVUearIOBhiXZ5V3ynxwA=="
  crossorigin=""></script>
```

Advierten de que pongas primero el `css` y después el `JavaScript`, tal y como se muestra en el ejemplo.

Lo primero que tenemos que hacer es definir las variables por defecto:

```javascript
var lat = '37.7634109';
var lng = '-0.7700499';
var maxZoom = '18';
var zoom = '12';
var map;
```

Tenemos que definir la latitud y la longitud donde queremos que se centre el mapa que vamos a generar. Y luego el *zoom* máximo que vamos a permitir (y que permite el sistema WMS) y el *zoom* por defecto que se mostrará al cargar el mapa, y por supuesto, hay que definir la variable donde se creará el mapa. Lo siguiente es crear el mapa:

```javascript
this.map = L.map('mapContainer').setView([lat, lng], this.zoom);

L.tileLayer.wms( '//www.ign.es/wms-inspire/pnoa-ma', {
    attribution: '<a href="http://www.ign.es" target="_blank">© Instituto Geográfico Nacional</a>',
    layers: 'OI.OrthoimageCoverage',
    format: 'image/jpeg',
    transparent: false,
    version: '1.3.0',
    crs: L.CRS.EPSG4326,
    maxZoom: this.maxZoom
}).addTo( this.map );
```

En principio ya estaría, ahora tenemos que crear un `div` con con el identificador `mapContainer` donde se mostrará el mapa:

```html
<div id="mapContainer" style="width: 400px; height: 400px;"></div>
```

Es importante definir el ancho y el alto, o no se mostrará nada. Pues ya estaría. Ahora podemos refinarlo on poco:

```javascript
var lat = '37.7634109';
var lng = '-0.7700499';
var maxZoom = '18';
var zoom = '12';
var map;

this.createMap('mapContainer');

function createMap(mapID) {
    this.map = L.map(mapID).setView([lat, lng], this.zoom);

    L.tileLayer.wms( '//www.ign.es/wms-inspire/pnoa-ma', {
        attribution: '<a href="http://www.ign.es" target="_blank">© Instituto Geográfico Nacional</a>',
        layers: 'OI.OrthoimageCoverage',
        format: 'image/jpeg',
        transparent: false,
        version: '1.3.0',
        crs: L.CRS.EPSG4326,
        maxZoom: this.maxZoom
    }).addTo( this.map );
}
```

Vale, expliquemos un poco el código. Lo primero es buscar un servicio WMS gratuito, en este caso es del Instituto Geográfico Nacional<sup>2</sup> de España, pero existen cientos... ya es cuestión de que busques el que más te interesa. En mi caso, suelo utilizar este WMS para mostrar mapas de España. 

Los campos que deben indicarse para conectar con el servicio WMS son:

- **attribution**: Sirve para mostrar la autoria del servicio. Es obligatorio indicarlo según la mayoría de condiciones de uso de estos servicios.
- **layers**: las capas que queremos mostrar. Los servicios WMS tienen una dirección donde se muestra todas las características, incluidas las capas disponibles, esta funcionalidad se llama *GetCapabilities* y por ejemplo en el caso del servicio utilizado en el ejemplo, lo puedes encontrar aquí: 
    + [PNOA GetCapabilities](https://www.ign.es/wms-inspire/pnoa-ma?request=GetCapabilities&service=WMS){.link-out}
- **format**: el formato de visualización del mapa. En el servicio *GetCapabilities* se encuentran todos los que están disponibles.
- **transparent**: si queremos que la capa sea transparente. A veces puede interesarnos.
- **versión**: es la versión del servicio WMS. También se puede ver en *GetCapabilities*.
- **crs**: es el Sistema de referencia de coordenadas. También se puede ver los disponibles en *GetCapabilities*. Este tema es complejo, y sinceramente, si solo buscas mostrar un mapa tampoco te compliques demasiado la vida y selecciona uno al azar... aunque el EPSG4326 es una buena elección.
- **maxZoom**: el *zoom* máximo que vamos a permitir. Sin olvidar que el servicio WMS también tendrá un máximo y no podremos sobrepasarlo.

¿Y si queremos añadir un marcador al mapa indicando el punto exacto de las coordenadas?

Pues creamos un marcador y lo añadimos al mapa:

```javascript
var marker = L.marker( new L.LatLng( this.lat, this.lng ) ).addTo( this.map );
```

En este caso estoy indicando que use las mismas coordenadas de latitud y longitud, pero se puden poner otras... o incluso varias. Para esto tendremos que añadir un marcador por cada punto.

Un último consejo, sobre todo si vamos a incluir el mapa con librerías reactivas tipo VueJS o AplineJS. En estos casos es preferible añadir una recarga del mapa una vez cargada la página... por si acaso:

```javascript
function reloadMap() {
    setTimeout(function(){ this.map.invalidateSize() }, 200);
}
```

Todo junto quedaría así:

```javascript
var lat = '37.7634109';
var lng = '-0.7700499';
var maxZoom = '18';
var zoom = '12';
var map, marker;

this.createMap('mapContainer');

this.marker = L.marker( new L.LatLng( this.lat, this.lng ) ).addTo( this.map );

function createMap(mapID) {
    this.map = L.map(mapID).setView([lat, lng], this.zoom);

    L.tileLayer.wms( '//www.ign.es/wms-inspire/pnoa-ma', {
        attribution: '<a href="http://www.ign.es" target="_blank">© Instituto Geográfico Nacional</a>',
        layers: 'OI.OrthoimageCoverage',
        format: 'image/jpeg',
        transparent: false,
        version: '1.3.0',
        crs: L.CRS.EPSG4326,
        maxZoom: this.maxZoom
    }).addTo( this.map );

    this.reloadMap();
}

function reloadMap() {
    setTimeout(function(){ this.map.invalidateSize() }, 200);
}
```

Esto último es básico si (como es mi caso) el proyecto utiliza `Livewire` y `AlpineJS`... y por experiencia os digo que pasa lo mismo con `Laravel Nova` y `VueJS`.

En la web oficial de `Leaflet` vas a encontrar muchos ejemplos:

+ [https://leafletjs.com/examples.html](https://leafletjs.com/examples.html){.link-out}

### Referencias 

1. https://es.wikipedia.org/wiki/Web_Map_Service
2. http://www.ign.es/web/ign/portal
