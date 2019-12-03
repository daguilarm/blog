<nav id="js-nav-menu" class="nav-menu hidden lg:hidden">
    <ul class="list-reset my-0">
        <li class="pl-4">
            <a
                title="{{ $page->siteName }}"
                href="/blog"
                class="nav-menu__item hover:text-blue {{ $page->isActive('/blog') ? 'active text-blue' : '' }}"
            >Blog</a>
        </li>
        <li class="pl-4">
            <a
                title="Sobre mi: {{ $page->siteName }}"
                href="/about"
                class="nav-menu__item hover:text-blue {{ $page->isActive('/about') ? 'active text-blue' : '' }}"
            >Sobre mi</a>
        </li>
        <li class="pl-4">
            <a
                title="Contacto: {{ $page->siteName }}"
                href="/contact"
                class="nav-menu__item hover:text-blue {{ $page->isActive('/contact') ? 'active text-blue' : '' }}"
            >Contacto</a>
        </li>
    </ul>
</nav>
