<nav class="hidden lg:flex items-center justify-end text-lg z-20">
    <a title="{{ $page->siteName }}" href="/blog"
        class="ml-6 text-white hover:text-blue-700 {{ $page->isActive('/blog') ? 'active text-blue-700 underline' : '' }}">
        Blog
    </a>

    <a title="Sobre mi: {{ $page->siteName }}" href="/about"
        class="ml-6 text-white hover:text-blue-700 {{ $page->isActive('/about') ? 'active text-blue-700 underline' : '' }}">
        Sobre mi
    </a>

    <a title="Proyectos: {{ $page->siteName }}" href="/projects"
        class="ml-6 text-white hover:text-blue-700 {{ $page->isActive('/projects') ? 'active text-blue-700 underline' : '' }}">
        Proyectos
    </a>

    <a title="Contacto: {{ $page->siteName }}" href="/contact"
        class="ml-6 text-white hover:text-blue-700 {{ $page->isActive('/contact') ? 'active text-blue-700 underline' : '' }}">
        Contacto
    </a>
</nav>
