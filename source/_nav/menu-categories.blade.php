@php
    $nav_cat_bg = "bg-blue-900";
    $nav_cat_bg_hover = "hover:bg-white";
    $nav_cat_text = "text-blue-100";
    $nav_cat_text_hover = "hover:text-blue-700";
@endphp

<div aria-label="categories" class="hidden lg:flex text-md px-4 py-2 h-11 w-full z-10 bg-blue-800 border-b-2 border-blue-800">
    <ul class="flex items-start m-0">
        <li class="mx-2">
            <a title="Artículos PHP" href="{{ $page->baseUrl }}/blog/categories/php/" class="{{ $nav_cat_bg }} {{ $nav_cat_bg_hover }} {{ $nav_cat_text }} {{ $nav_cat_text_hover }} rounded text-xs py-1 px-3">
                PHP
            </a>
        </li>
        <li class="mx-2">
            <a title="Artículos Laravel" href="{{ $page->baseUrl }}/blog/categories/laravel/" class="{{ $nav_cat_bg }} {{ $nav_cat_bg_hover }} {{ $nav_cat_text }} {{ $nav_cat_text_hover }} rounded text-xs py-1 px-3">
                Laravel
            </a>
        </li>
        <li class="mx-2">
            <a title="Artículos Javascript" href="{{ $page->baseUrl }}/blog/categories/javascript/" class="{{ $nav_cat_bg }} {{ $nav_cat_bg_hover }} {{ $nav_cat_text }} {{ $nav_cat_text_hover }} rounded text-xs py-1 px-3">
                Javascript
            </a>
        </li>
        <li class="mx-2">
            <a title="Artículos SEO" href="{{ $page->baseUrl }}/blog/categories/seo/" class="{{ $nav_cat_bg }} {{ $nav_cat_bg_hover }} {{ $nav_cat_text }} {{ $nav_cat_text_hover }} rounded text-xs py-1 px-3">
                SEO
            </a>
        </li>
        <li class="mx-2">
            <a title="Artículos AlpineJS" href="{{ $page->baseUrl }}/blog/categories/alpinejs/" class="{{ $nav_cat_bg }} {{ $nav_cat_bg_hover }} {{ $nav_cat_text }} {{ $nav_cat_text_hover }} rounded text-xs py-1 px-3">
                AlpineJS
            </a>
        </li>
        <li class="mx-2">
            <a title="Artículos Laravel Livewire" href="{{ $page->baseUrl }}/blog/categories/livewire/" class="{{ $nav_cat_bg }} {{ $nav_cat_bg_hover }} {{ $nav_cat_text }} {{ $nav_cat_text_hover }} rounded text-xs py-1 px-3">
                Laravel Livewire
            </a>
        </li>
        <li class="mx-2">
            <a title="Artículos Bases de datos" href="{{ $page->baseUrl }}/blog/categories/database/" class="{{ $nav_cat_bg }} {{ $nav_cat_bg_hover }} {{ $nav_cat_text }} {{ $nav_cat_text_hover }} rounded text-xs py-1 px-3">
                Bases de Datos
            </a>
        </li>
        <li class="mx-2">
            <a title="Artículos HTML y HTML5" href="{{ $page->baseUrl }}/blog/categories/html/" class="{{ $nav_cat_bg }} {{ $nav_cat_bg_hover }} {{ $nav_cat_text }} {{ $nav_cat_text_hover }} rounded text-xs py-1 px-3">
                HTML
            </a>
        </li>
        <li class="mx-2">
            <a title="Artículos Composer" href="{{ $page->baseUrl }}/blog/categories/composer/" class="{{ $nav_cat_bg }} {{ $nav_cat_bg_hover }} {{ $nav_cat_text }} {{ $nav_cat_text_hover }} rounded text-xs py-1 px-3">
                Composer
            </a>
        </li>
    </ul>
</div>