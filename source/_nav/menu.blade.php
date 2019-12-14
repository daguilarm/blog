<nav class="hidden lg:flex items-center justify-end text-lg z-20">
    <a title="{{ $page->siteName }}" href="/blog"
        class="ml-6 text-white hover:text-blue-600 {{ $page->isActive('/blog') ? 'active text-blue-600' : '' }}">
        Blog
    </a>

    <a title="Sobre mi: {{ $page->siteName }}" href="/about"
        class="ml-6 text-white hover:text-blue-600 {{ $page->isActive('/about') ? 'active text-blue-600' : '' }}">
        Sobre mi
    </a>

    <a title="Contacto: {{ $page->siteName }}" href="/contact"
        class="ml-6 text-white hover:text-blue-600 {{ $page->isActive('/contact') ? 'active text-blue-600' : '' }}">
        Contacto
    </a>
</nav>
