<nav id="js-nav-menu" class="nav-menu hidden lg:hidden">
    <ul class="my-0">
        <li class="pl-4">
            <a
                title="<?php echo e($page->siteName); ?>"
                href="/blog"
                class="nav-menu__item hover:text-blue-600 <?php echo e($page->isActive('/blog') ? 'active text-blue-600' : ''); ?>"
            >Blog</a>
        </li>
        <li class="pl-4">
            <a
                title="Sobre mi: <?php echo e($page->siteName); ?>"
                href="/about"
                class="nav-menu__item hover:text-blue-600 <?php echo e($page->isActive('/about') ? 'active text-blue-600' : ''); ?>"
            >Sobre mi</a>
        </li>
        <li class="pl-4">
            <a
                title="Contacto: <?php echo e($page->siteName); ?>"
                href="/contact"
                class="nav-menu__item hover:text-blue-600 <?php echo e($page->isActive('/contact') ? 'active text-blue-600' : ''); ?>"
            >Contacto</a>
        </li>
    </ul>
</nav>
<?php /**PATH /Users/daguilarm/Sites/blog/source/_nav/menu-responsive.blade.php ENDPATH**/ ?>