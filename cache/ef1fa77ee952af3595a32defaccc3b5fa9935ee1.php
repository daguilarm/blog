<nav class="hidden lg:flex items-center justify-end text-lg z-20">
    <a title="<?php echo e($page->siteName); ?>" href="/blog"
        class="ml-6 text-white hover:text-blue-700 hover:bg-blue-100 hover:shadow rounded py-1 px-3 <?php echo e($page->isActive('/blog') ? 'active' : ''); ?>">
        Blog
    </a>

    <a title="Sobre mi: <?php echo e($page->siteName); ?>" href="/about"
        class="ml-6 text-white hover:text-blue-700 hover:bg-blue-100 hover:shadow rounded py-1 px-3 <?php echo e($page->isActive('/about') ? 'active' : ''); ?>">
        Sobre mi
    </a>

    <a title="Proyectos: <?php echo e($page->siteName); ?>" href="/projects"
        class="ml-6 text-white hover:text-blue-700 hover:bg-blue-100 hover:shadow rounded py-1 px-3 <?php echo e($page->isActive('/projects') ? 'active' : ''); ?>">
        Proyectos
    </a>

    <a title="Contacto: <?php echo e($page->siteName); ?>" href="/contact"
        class="ml-6 text-white hover:text-blue-700 hover:bg-blue-100 hover:shadow rounded py-1 px-3 <?php echo e($page->isActive('/contact') ? 'active' : ''); ?>">
        Contacto
    </a>
</nav>
<?php /**PATH /Users/daguilarm/Sites/blog/source/_nav/menu.blade.php ENDPATH**/ ?>