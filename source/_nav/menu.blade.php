<nav class="hidden lg:flex items-center justify-end text-lg">
    <a title="{{ $page->siteName }}" href="/blog"
        class="ml-6 text-grey-darker hover:text-blue-dark {{ $page->isActive('/blog') ? 'active text-blue-dark' : '' }}">
        Blog
    </a>

    <a title="Sobre mi: {{ $page->siteName }}" href="/about"
        class="ml-6 text-grey-darker hover:text-blue-dark {{ $page->isActive('/about') ? 'active text-blue-dark' : '' }}">
        Sobre mi
    </a>

    <a title="Contacto: {{ $page->siteName }}" href="/contact"
        class="ml-6 text-grey-darker hover:text-blue-dark {{ $page->isActive('/contact') ? 'active text-blue-dark' : '' }}">
        Contacto
    </a>
</nav>
