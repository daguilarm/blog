{{-- Header --}}
<header class="flex items-center h-32 shadow-xl bg-blue-600" role="banner">
    {{-- header container --}}
    <div class="container flex items-center max-w-8xl mx-auto px-4 lg:px-8">
        {{-- Logo --}}
        <div class="z-20 -mt-20 sm:mt-0">
            <a href="/" title="{{ $page->siteName }}" class="block sm:hidden absolute top-0 mt-3 text-yellow-400">El blog de Damián Aguilar</a>
            <a href="/" title="{{ $page->siteName }}" class="hidden sm:block">
                <div class="text-lg text-yellow-400 p-2">El blog de</div>
                <div class="text-2xl font-bold text-white p-2 -mt-4">Damián Aguilar</div>
            </a>
        </div>

        {{-- Search --}}
        <div id="vue-search" class="flex flex-1 justify-end items-center relative">
            <search class="z-50"></search>

            {{-- Sections --}}
            @include('_layouts._nav.menu-sections')

            {{-- Toggle icon --}}
            @include('_layouts._nav.menu-toggle')
        </div>
    </div>
</header>

@include('_layouts._nav.menu-responsive')