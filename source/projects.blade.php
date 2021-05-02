@extends('_layouts.master')

@push('meta')
    @php
        $page->title = 'Proyectos en los que estoy trabajando';
        $page->description = 'Listado de proyectos desarrollados por Damián Aguilar en la actualidad.';
    @endphp
    <meta property="og:title" content="Proyectos en los que estoy trabajando - {{ $page->siteName }}" />
    <meta property="og:type" content="website" />
    <meta property="og:url" content="{{ $page->getUrl() }}"/>
    <meta property="og:description" content="Proyectos - Damián Aguilar - Programador y desarrollador web. Programando con Laravel y Vuejs. Graduado en Ingeniería Agroalimentaria y Agroambiental" />
@endpush

@section('body')
    <h1 class="text-blue-800 text-3xl md:text-4xl lg:text-5xl">Proyectos</h1>
    <h2 class="text-xl font-normal">Actualmente estoy desarrollando las siguientes proyectos:</h2>
    <section id="belich" class="mt-8 p-6 border-b border-gray-400">
        <h3 class="text-xl">a) Laravel Livewire multi select (combobox).</h3>
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
        </div>
        <div class="w-full mt-12 sm:mt-0">
            <p><strong>Proyecto y documentación en Github:</strong> <a href="https://github.com/daguilarm/livewire-combobox">https://github.com/daguilarm/livewire-combobox</a></p>
        </div>
    </section>
    <section id="belich" class="mt-8 p-6 border-b border-gray-400">
        <h3 class="text-xl">b) Belich Tables.</h3>
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
        </div>
    </section>
@endsection
