<nav class="hidden lg:flex items-center justify-end text-lg z-20">
    <a title="{{ $page->siteName }}" href="/blog"
        class="ml-6 text-white hover:text-blue-700 hover:bg-blue-100 hover:shadow rounded py-1 px-3 {{ $page->isActive('/blog') ? 'active' : '' }}">
        Artículos
    </a>

    <a title="Sobre mi: {{ $page->siteName }}" href="/about"
        class="ml-6 text-white hover:text-blue-700 hover:bg-blue-100 hover:shadow rounded py-1 px-3 {{ $page->isActive('/about') ? 'active' : '' }}">
        Sobre mi
    </a>

    <a title="Proyectos: {{ $page->siteName }}" href="/projects"
        class="ml-6 text-white hover:text-blue-700 hover:bg-blue-100 hover:shadow rounded py-1 px-3 {{ $page->isActive('/projects') ? 'active' : '' }}">
        Proyectos
    </a>

    <a title="Contacto: {{ $page->siteName }}" href="/contact"
        class="ml-6 text-white hover:text-blue-700 hover:bg-blue-100 hover:shadow rounded py-1 px-3 {{ $page->isActive('/contact') ? 'active' : '' }}">
        Contacto
    </a>
</nav>
