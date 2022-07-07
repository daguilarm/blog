@extends('_layouts.master')

@push('metatags')
    <link rel="canonical" href="https://daguilar.dev/blog/categories/{{ $page->category }}/">
@endpush

@section('body')
    <h1 class="text-blue-800 text-2xl md:text-4xl lg:text-5xl">{{ $page->title }}</h1>

    <div class="text-2xl mb-2 py-4 italic">
        @yield('content')
    </div>

    @foreach ($page->posts($posts) as $post)
        @include('_components.post-preview-inline')

        @if ($loop->iteration == 50)
            @break
        @endif
    @endforeach
@stop
