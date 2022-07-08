---
extends: _layouts.master
title: El blog de programación de Damián Aguilar
description: Blog sobre programación de Damián Aguilar, donde se habla sobre todo de PHP, javascript, vuejs, livewire, phyton, java... y mucho más.
---

@section('body')

    <h1 class="mt-8 text-4xl font-extrabold text-gray-700">
        Últimos artículos sobre programación, diseño web, marketing y SEO
    </h1>
    <h2 class="-mt-1 mb-8 p-2 text-xl shadow text-blue-700 italic border-l-8 bg-gray-200 border-blue-700 pl-6 py-4">
        En este blog nos gusta principalemente hablar sobre: PHP, Laravel, Javascript, VueJS, AlpineJS y Angular
    </h2>

    {{-- Pin post --}}
    @foreach ($posts->where('featured', false)->where('pin', true)->take(2)->chunk(2) as $row)
        <div class="flex flex-col md:flex-row w-full">
            @foreach ($row as $post)
                <article class="flex w-full md:w-1/2 md:mx-6">
                    @include('_components.post-preview-inline', ['pin' => true])
                </article>
            @endforeach
        </div>
    @endforeach

    {{-- Regular post order by date --}}
    @foreach ($posts->where('featured', false)->where('pin', false)->take(20)->chunk(2) as $row)
        <div class="flex flex-col md:flex-row w-full">
            @foreach ($row as $post)
                <div class="flex w-full md:w-1/2 md:mx-6 ">
                    @include('_components.post-preview-inline')
                </div>
            @endforeach
        </div>

    @endforeach
@stop
