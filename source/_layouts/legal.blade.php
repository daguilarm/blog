@extends('_layouts.master')

@section('body')
    @yield('content')

    <p class="flex justify-start text-blue-700 text-md md:mt-0">
        <div>Fecha de publicación: <time datetime="{{ date('Y-m-d', $page->date) }}">{{ date('d/m/Y', $page->date) }}</time></div>
        <div>Fecha de actualización: <time datetime="{{ date('Y-m-d', $page->updated) }}">{{ date('d/m/Y', $page->updated) }}</time></div>
    </p>
@endsection