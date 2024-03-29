---
extends: _layouts.post
section: content
title: Usar elemento datalist como select mediante JavaScript
date: 2020-10-26
updated: 2022-07-05
description: Convertir un elemento datalist en un elemento select avanzado, es decir, añadiendo valores y claves, permitiendo lo mejor de ambos elementos html.
categories: [html, javascript]
---

Un elemento `datalist` tiene el siguiente aspecto:

```html
<input
  list="datalist-example"
  id="example"
>
<datalist id="datalist-example">
  <option>Elemento 1</option>
  <option>Elemento 2</option>
  <option>Elemento 3</option>
  <option>Elemento 4</option>
  <option>Elemento 5</option>
</datalist>
```

El problema radica en que queremos que se comporte como un elemento `select`, es decir, queremos que funcione con el siguiente planteamiento:

```html
<input
  list="datalist-example"
  id="example"
>
<datalist id="datalist-example">
  <option value="1">Elemento 1</option>
  <option value="2">Elemento 2</option>
  <option value="3">Elemento 3</option>
  <option value="4">Elemento 4</option>
  <option value="5">Elemento 5</option>
</datalist>
```

El problema es que no va a funcionar, ya que va a considerar tanto al valor como al texto como un todo, y va a mostrar en pantalla `1 Elemento 1`, `2 Elemento 2`,...

Para solucionar esta situación tenemos que añadir el campo con el valor dentro de un campo personalizado `data`:

```html
<input
  list="datalist-example"
  id="example"
>
<datalist id="datalist-example">
  <option data-value="1">Elemento 1</option>
  <option data-value="2">Elemento 2</option>
  <option data-value="3">Elemento 3</option>
  <option data-value="4">Elemento 4</option>
  <option data-value="5">Elemento 5</option>
</datalist>
```

Ahora nos muestra los resultados como queremos, y vincula a cada elemento un valor. El siguiente paso es añadir un campo de formulario oculto que será el que envie la información y no el campo vinculado al `datalist`:

```html
<input
  list="datalist-example"
  id="visible-example"
>
<datalist id="datalist-example">
  <option data-value="1">Elemento 1</option>
  <option data-value="2">Elemento 2</option>
  <option data-value="3">Elemento 3</option>
  <option data-value="4">Elemento 4</option>
  <option data-value="5">Elemento 5</option>
</datalist>
<input
  type="hidden"
  id="example"
>
```

Ahora el campo con el atributo `id="example"`, será el que envie la información al `Controlador` o donde sea que enviemos la información. Pero a pesar de los cambios, esto sigue sin funcionar. Hay que utilizar un poco de `JavaScript` para conseguirlo.

Lo ideal sería añadir algo así con `AlpineJS`:

```html
<input
  list="datalist-example"
  id="visible-example"
  x-on:change="$refs.hiddenAttribute.value = this.value"
>
<datalist id="datalist-example">
  <option data-value="1">Elemento 1</option>
  <option data-value="2">Elemento 2</option>
  <option data-value="3">Elemento 3</option>
  <option data-value="4">Elemento 4</option>
  <option data-value="5">Elemento 5</option>
</datalist>
<input
  type="hidden"
  id="example"
  x-ref="hiddenAttribute"
>
```

Obviamente no funciona. La idea del ejemplo anterior es solo mostrar como los eventos en un `datalist` no funcionan como lo harían en cualquier otro elemento. Para conseguirlo hay que hacer algunas trampas. 

En este hilo de **Stackoverflow** en encontrado varias propuestas interesantes, y las he mezclado un poco para obtener una solución global y que funcione en todos los navegadores:

+ [https://stackoverflow.com/questions/23647359/how-do-i-get-the-change-event-for-a-datalist](https://stackoverflow.com/questions/23647359/how-do-i-get-the-change-event-for-a-datalist){.link-out}

El resultado ha sido este:

```html
<input
  list="datalist-example"
  id="visible-example"
>
<datalist id="datalist-example">
  <option data-value="1">Elemento 1</option>
  <option data-value="2">Elemento 2</option>
  <option data-value="3">Elemento 3</option>
  <option data-value="4">Elemento 4</option>
  <option data-value="5">Elemento 5</option>
</datalist>
<input
  type="hidden"
  id="example"
>

<script>
  var timer;
  var dropdown = document.getElementById('visible-example');

  dropdown
      .addEventListener('change', function(event) {
          var target = event.target.value;
          var datalist = document.getElementById('datalist-example').childNodes;
          timer = setTimeout(function() {
              for (var i = 0; i < datalist.length; i++) {
                  if (datalist[i].value === target) {
                      document.getElementById('example').value = datalist[i].dataset.text;
                      break;
                  }
              }
          }, 1);
      });

  dropdown.addEventListener('blur', function(e) {
      clearTimeout(timer);
  });
</script>
```

En mi caso como esto va a ser un componente de `Laravel` y como no quiero lios al añadir varios en una página, he optado por añadir una clave única a las variables. Primero he creado la clave:

```blade
// Por ejemplo...
@php 
  $key = md5(Str::random());
@endphp
```

Y después he cambiado el código así:

```html
<input
  list="datalist-example-{{ $key }}"
  id="visible-example-{{ $key }}"
>
<datalist id="datalist-example-{{ $key }}">
  <option data-value="1">Elemento 1</option>
  <option data-value="2">Elemento 2</option>
  <option data-value="3">Elemento 3</option>
  <option data-value="4">Elemento 4</option>
  <option data-value="5">Elemento 5</option>
</datalist>
<input
  type="hidden"
  id="example-{{ $key }}"
>

<script>
  var timer{{ $key }};
  var dropdown{{ $key }} = document.getElementById('visible-example-{{ $key }}');

  dropdown{{ $key }}
      .addEventListener('change', function(event) {
          var target = event.target.value;
          var datalist = document.getElementById('datalist-example-{{ $key }}').childNodes;
          timer = setTimeout(function() {
              for (var i = 0; i < datalist.length; i++) {
                  if (datalist[i].value === target) {
                      document.getElementById('example-{{ $key }}').value = datalist[i].dataset.text;
                      break;
                  }
              }
          }, 1);
      });

  dropdown{{ $key }}.addEventListener('blur', function(e) {
      clearTimeout(timer{{ $key }});
  });
</script>
```

Imagino que esto es mejorable... pero por el momento funciona perfectamente. También quiero comentar que utilizo esto sólo cuando los campos `select` tienen muchas opciones, y es más práctico buscar que listar. 

Lo que hago es crear dos componentes en `Laravel`, uno para los campos `select` y otro para los campos `datalist`, y entonces creo un tercer componente llamado `selector`, que tiene el siguiente código:

```php
@isset($options)
    @if(count($options) >= 12)
        @include('components.fields.datalist')
    @else
        @include('components.fields.select')
    @endif
@endisset
```

Lo que hace es contar los resultados a mostrar y en función de estos, muestra el resultado como si fuera un `select` o un `datalist`.
