@extends('_layouts.master')

@push('metatags')
    <link rel="canonical" href="https://daguilar.dev/blog/categories/{{ $page->category }}/">
@endpush

@section('body')
    <h1 class="text-blue-800 text-3xl md:text-4xl lg:text-5xl">{{ $page->title }}</h1>

    <div class="text-2xl border-b border-blue-200 mb-6 pb-10">
        @yield('content')
    </div>

    @foreach ($page->posts($posts) as $post)
        @include('_components.post-preview-inline')

        @if (! $loop->last)
            <hr class="w-full border-b mt-2 mb-6">
        @endif

        @if ($loop->iteration == 50)
            @break
        @endif
    @endforeach
@stop
