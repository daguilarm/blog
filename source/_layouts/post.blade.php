@extends('_layouts.master')

@push('metatags')
    @if ($page->categories)
        @foreach ($page->categories as $i => $category)
            <meta property="article:tag" content="{{ $category }}">
        @endforeach
    @endif
    <meta property="article:published_time" content="{{ date('c', $page->date) }}">
    <meta property="article:updated_time" content="{{ date('c', $page->update ?? $page->date) }}">
    {{-- <link rel="canonical" href="https://daguilar.dev/blog/{{ $page->getFilename() }}/"> --}}
@endpush

@section('body')

    <article class=" bg-white rounded-xl shadow-xl p-9 my-10 border border-gray-300">
        <h1 class="leading-none mb-6 text-blue-800 text-3xl md:text-4xl lg:text-5xl">{{ $page->title }}</h1>

        <div class="flex justify-start text-gray-600 text-xl md:mt-0 mb-4">
            <div>Autor: {{ $page->author }}</div>
            <a href="https://twitter.com/daguilarm" target="_black" class="mx-2"><img src="/assets/img/twitter.png" alt="twitter" class="opacity-75 hover:opacity-100 h-8 w-8 bg-white rounded-full"></a>
            <div>- Creado el {{ date('d/m/Y', $page->date) }}</div>
            @if($page->updated)
                <div class="text-orange-600 ml-2">y Actualizado el {{ date('d/m/Y', $page->updated) }}</div>
            @endif
        </div>

        @if ($page->categories)
            @foreach ($page->categories as $i => $category)
                <a
                    href="{{ '/blog/categories/' . $category }}/"
                    title="View posts in {{ $category }}"
                    class="inline-block bg-blue-200 hover:bg-blue-400 leading-loose tracking-wide text-blue-600 hover:text-white uppercase text-xs font-semibold rounded mr-4 px-3 pt-px"
                >{{ $category }}</a>
            @endforeach
        @endif

        <div v-pre>
            @yield('content')
        </div>

        {{-- <nav class="flex justify-between text-sm md:text-base">
            <div>
                @if ($next = $page->getNext())
                    <a href="{{ $next->getUrl() }}" title="Older Post: {{ $next->title }}">
                        &LeftArrow; {{ $next->title }}
                    </a>
                @endif
            </div>

            <div>
                @if ($previous = $page->getPrevious())
                    <a href="{{ $previous->getUrl() }}" title="Newer Post: {{ $previous->title }}">
                        {{ $previous->title }} &RightArrow;
                    </a>
                @endif
            </div>
        </nav> --}}
    </article>
    
@endsection
