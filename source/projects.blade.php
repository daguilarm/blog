---
title: Proyectos en los que estoy trabajando actualmente
description: Listado de proyectos desarrollados por el programador e ingeniero Damián Aguilar. Actualmente estoy trabajando en todos estos proyectos.
---
@extends('_layouts.master')

@section('body')
    <h1 class="text-blue-800 text-3xl md:text-4xl lg:text-5xl">Proyectos</h1>
    <h2 class="text-xl font-normal">Actualmente estoy desarrollando las siguientes proyectos:</h2>
    <section id="belich1" class="mt-8 p-6 border-b border-blue-400">
        <h3 class="text-xl">a) Empleatis.com - Metabuscador de empleo.</h3>
        <p>
            Un metabuscador de empleo desarrollado con Laravel, Livewire y Alpinejs. Busca las ofertas laborales entre los mejores buscadores de empleo de internet.
        </p>
        <p>
            Tiene las siguientes características:
        </p>
        <div class="sm:flex">
            <ul class="w-full sm:flex-1">
                <li>Busqueda de ofertas en los principales portales de empleo.</li>
                <li>Todos los días se actualizan las bases de datos desde las diferentes fuentes.</li>
                <li>Una vez obtenidos los datos, se clasifican las diferentes ofertas de empleo por categorias.</li>
                <li>Mediante un algoritmo de puntuación (Jrank) se ordenan las ofertas laborales en función de 17 parámetros.</li>
                <li>Desarrollando con PHP, Laravel, Livewire y AlpineJS.</li>
            </ul>
        </div>
        <div class="w-full mt-12 sm:mt-0">
            <p><strong>Página web:</strong> <a href="https://empleatis.com">https://empleatis.com</a></p>
        </div>
        <h3 class="text-xl">b) Laravel Livewire multi select (combobox).</h3>
        <p>
            Es un componente dinámico de Laravel Livewire para gestionar campos <code>select</code> dependientes entre ellos.
        </p>
        <p>
            Tiene las siguientes características:
        </p>
        <div class="sm:flex">
            <ul class="w-full sm:flex-1">
                <li>Infinitos niveles de dependencia entre los elementos.</li>
                <li>Componentes totalmente configurables.</li>
                <li>Estilos css, totalmente configurables.</li>
                <li>Sin necesidad de modificar código del <i>package</i>.</li>
                <li>Funciona con Laravel Livewire y TailwindCSS</li>
                <li>Y mucho mas...</li>
            </ul>
            <div class="mt-12 w-full sm:flex-1 sm:mt-8">
                <img src="/assets/img/projects/liveware-combobox.gif"
                    alt="Laravel Livewire combobox - selects dependientes"
                    class="rounded shadow-lg"
                >
            </div>
        </div>
        <div class="w-full mt-12 sm:mt-0">
            <p><strong>Proyecto y documentación en Github:</strong> <a href="https://github.com/daguilarm/livewire-combobox">https://github.com/daguilarm/livewire-combobox</a></p>
            <p><strong>Artículo:</strong> <a href="https://daguilar.dev/blog/laravel_select-dependiente-multinivel-combobox-para-laravel/">Artículo sobre Laravel Livewire Combobox</a></p>
        </div>
    </section>
    <section id="belich2" class="mt-8 p-6 border-b border-blue-400">
        <h3 class="text-xl">c) Belich Tables.</h3>
        <p>
            Es un componente dinámico de Laravel Livewire para tablas de datos. Es como el famoso datatables basado en Jquery, pero utilizando Livewire, AlpineJS y TailwindCSS.
        </p>
        <p>
            El package está inspirado en el desarrollado por <a href="https://github.com/rappasoft/laravel-livewire-tables" target="_blank">rappasoft</a>, al que se le han añadido bastantes mejoras:
        </p>
        <div class="sm:flex">
            <ul class="w-full sm:flex-1">
                <li>Practicamente todo el código ha sido refactorizado y replanteado desde 0.</li>
                <li>Filtros personalizados para cada columna.</li>
                <li>Añadir nuevos recursos a la base de datos.</li>
                <li>Botones de acciones.</li>
                <li>Paginación de resultados.</li>
                <li>Selección de columnas mediante checkboxes.</li>
                <li>Mensajes y modals preconfigurados.</li>
                <li>Totalmente reconfigurado para TailwindCSS</li>
                <li>Completa customización del package.</li>
                <li>Y mucho mas...</li>
            </ul>
            <div class="mt-12 w-full sm:flex-1 sm:mt-8">
                <img src="/assets/img/projects/belich-tables.png"
                    alt="Laravel Livewire para tablas de datos"
                    class="rounded shadow-lg"
                >
            </div>
        </div>
        <div class="w-full mt-12 sm:mt-0">
            <p><strong>Proyecto en Github:</strong> <a href="https://github.com/daguilarm/belich-tables">https://github.com/daguilarm/belich-tables</a></p>
            <p><strong>Documentación:</strong> <a href="https://daguilarm.github.io/belich-tables">https://daguilarm.github.io/belich-tables</a></p>
            <p><strong>Artículo:</strong> <a href="https://daguilar.dev/blog/laravel_nuevo-package-para-laravel-para-la-gestion-de-tablas-de-datos/">Artículo sobre Belich Tables</a></p>
        </div>
    </section>
@endsection
