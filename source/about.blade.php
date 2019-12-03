@extends('_layouts.master')

@push('meta')
    <meta property="og:title" content="Sobre mi - {{ $page->siteName }}" />
    <meta property="og:type" content="website" />
    <meta property="og:url" content="{{ $page->getUrl() }}"/>
    <meta property="og:description" content="Damián Aguilar - Programador y desarrollador web. Programando con Laravel y Vuejs. Graduado en Ingeniería Agroalimentaria y Agroambiental" />
@endpush

@section('body')
    <h1>Acerca de mi</h1>

    <img src="/assets/img/damian-aguilar.jpeg"
        alt="Damián Aguilar"
        class="flex rounded-full h-64 w-64 bg-contain mx-auto md:float-right my-6 md:ml-10"
    >

    <p>Hola!</p>
    <p>Me llamo Damián Aguilar y te doy la bienvenida a mi blog sobre php, laravel, vuejs... y programación en general. Me inicié en la programación en el año 2002, empezando a programar con php. Desde entonces otros lenguajes como Java, Javascript o Phyton se han cruzado en mi camino.</p>
    <p>Los últimos años, he estado trabajado en la Universidad Miguel Hernández como investigador, desarrollando aplicaciones (basadas en Laravel), para la mejora y optimización agraria. Esto me lleva a mi formación académica, ya que aunque siempre he trabajado como programador, soy Graduado en Ingeniería Agroalimentaria, y actualemente, estoy terminando el Doctorado en la Escuela Politénica Superior de Orihuela.</p>
    <p>Actualmente, trabajo como Freelance desarrollando aplicaciones basadas en Laravel y Vuejs.</p>
@endsection
