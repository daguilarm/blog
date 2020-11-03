@extends('_layouts.master')

@push('meta')
    <meta property="og:title" content="{{ $page->title }}" />
    <meta property="og:type" content="article" />
    <meta property="og:url" content="{{ $page->getUrl() }}"/>
    <meta property="og:description" content="{{ $page->description }}" />
@endpush

@section('body')
    @if ($page->cover_image)
        <div class="w-full flex justify-center">
            <img src="{{ $page->cover_image }}" alt="{{ $page->title }} cover image" class="mb-2">
        </div>
    @endif

    <h1 class="leading-none mb-6 text-blue-800 text-3xl md:text-4xl lg:text-5xl">{{ $page->title }}</h1>

    <p class="text-gray-600 text-xl md:mt-0">{{ $page->author }}  •  {{ date('d/m/Y', $page->date) }} • <a href="https://twitter.com/daguilarm" target="_black"><img src="/assets/img/twitter.png" alt="twitter" class="opacity-75 hover:opacity-100"></a></p>

    @if ($page->categories)
        @foreach ($page->categories as $i => $category)
            <a
                href="{{ '/blog/categories/' . $category }}"
                title="View posts in {{ $category }}"
                class="inline-block bg-blue-200 hover:bg-blue-400 leading-loose tracking-wide text-blue-600 hover:text-white uppercase text-xs font-semibold rounded mr-4 px-3 pt-px"
            >{{ $category }}</a>
        @endforeach
    @endif

    <div class="border-b border-blue-200 mb-10 pb-4" v-pre>
        @yield('content')
    </div>

    <nav class="flex justify-between text-sm md:text-base">
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
    </nav>
@endsection
