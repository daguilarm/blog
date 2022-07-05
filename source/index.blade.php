---
extends: _layouts.master
title: El blog de programación de Damián Aguilar
description: Blog sobre programación de Damián Aguilar, donde se habla sobre todo de PHP, javascript, vuejs, livewire, phyton, java... y mucho más.
---

@section('body')

    <h1 class="mt-8 text-2xl font-extrabold text-blue-700">
        Últimos artículos sobre programación, diseño web, marketing y SEO.
    </h1>
    <h2 class="-mt-1 mb-8 p-2 text-xl text-gray-600 italic border-l-4 bg-neutral-100 text-neutral-600 border-neutral-500">
        En este blog nos gustan principalemente hablar sobre las siguientes tecnologías: PHP, Laravel, Javascript, VueJS, AlpineJS y Angular.
    </h2>

    @foreach ($posts->where('featured', false)->take(20)->chunk(2) as $row)
        <div class="flex flex-col md:flex-row w-full">
            @foreach ($row as $post)
                <div class="flex w-full md:w-1/2 md:mx-6 ">
                    @include('_components.post-preview-inline', ['minHeight' => true])
                </div>
            @endforeach
        </div>

    @endforeach
@stop
