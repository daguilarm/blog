---
pagination:
    title: Artículos sobre programación y desarrollo web
    collection: posts
    perPage: 20
---
@extends('_layouts.master')

@section('body')
    <h1 class="text-blue-800 text-3xl md:text-4xl lg:text-5xl">Últimos artículos sobre programación web, SEO y marketing</h1>
    <p>Aquí vas a encontrar artículos sobre situaciones que me voy encontrando en mi día a día con la programación, así que cuantos más problemas me encuentre, más artículos iré añadiendo...</p>

    @foreach ($pagination->items as $post)
        @include('_components.post-preview-inline')
    @endforeach

    @if ($pagination->pages->count() > 1)
        <nav class="flex text-base my-8">
            @if ($previous = $pagination->previous)
                <a
                    href="{{ $previous }}/"
                    title="Previous Page"
                    class="bg-gray-200 hover:bg-gray-400 rounded mr-3 px-5 py-3"
                >&LeftArrow;</a>
            @endif

            @foreach ($pagination->pages as $pageNumber => $path)
                <a
                    href="{{ $path }}/"
                    title="Go to Page {{ $pageNumber }}"
                    class="bg-gray-200 hover:bg-gray-400 text-blue-darker rounded mr-3 px-5 py-3 {{ $pagination->currentPage == $pageNumber ? 'text-blue-dark' : '' }}"
                >{{ $pageNumber }}</a>
            @endforeach

            @if ($next = $pagination->next)
                <a
                    href="{{ $next }}/"
                    title="Next Page"
                    class="bg-gray-200 hover:bg-gray-400 rounded mr-3 px-5 py-3"
                >&RightArrow;</a>
            @endif
        </nav>
    @endif
@stop
