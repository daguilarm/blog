<?php $__env->startPush('meta'); ?>
    <?php
        $page->title = 'Proyectos en los que estoy trabajando';
        $page->description = 'Listado de proyectos desarrollados por Damián Aguilar en la actualidad.';
    ?>
    <meta property="og:title" content="Proyectos en los que estoy trabajando - <?php echo e($page->siteName); ?>" />
    <meta property="og:type" content="website" />
    <meta property="og:url" content="<?php echo e($page->getUrl()); ?>"/>
    <meta property="og:description" content="Proyectos - Damián Aguilar - Programador y desarrollador web. Programando con Laravel y Vuejs. Graduado en Ingeniería Agroalimentaria y Agroambiental" />
<?php $__env->stopPush(); ?>

<?php $__env->startSection('body'); ?>
    <h1 class="text-blue-800 text-3xl md:text-4xl lg:text-5xl">Proyectos</h1>
    <h2 class="text-xl font-normal">Actualmente estoy desarrollando las siguientes proyectos:</h2>
    <section id="belich" class="mt-8 p-6">
        <h3 class="text-xl">a) Belich: panel de administración para Laravel.</h3>
        <p>
            Belich es un panel de administración completo, desarrollado como un <i>package</i> de <a href="https://laravel.com" target="_blank" rel="noopener">Laravel</a>,
            entre otras funcionalidades, ofrece:
        </p>
        <div class="sm:flex">
            <ul class="w-full sm:flex-1">
                <li>Barra superior o lateral totalmente configurable.</li>
                <li>Descarga de recursos en formato: EXCEL y CSV</li>
                <li>Gestión nativa de políticas y autorización.</li>
                <li>Completa customización del package.</li>
                <li>Configuración de botones de acciones.</li>
                <li>Gestión de breadcrumbs.</li>
                <li>Dashboard configurable.</li>
                <li>Tabs, panels, cards, gráficas,...</li>
                <li>Campos de formulario predeterminados y opción de crear campos propios.</li>
                <li>Campos de formulario condicionales.</li>
                <li>Campos relacionales.</li>
                <li>Busqueda en tiempo real.</li>
                <li>Y mucho mas...</li>
            </ul>
            <div class="mt-12 w-full sm:flex-1 sm:mt-8">
                <img src="/assets/img/projects/belich.jpg"
                    alt="Belich: panel de administración para Laravel"
                    class="rounded shadow-lg"
                >
            </div>
        </div>
        <div class="w-full mt-12 sm:mt-0">
            <p><strong>Proyecto en Github:</strong> <a href="https://github.com/daguilarm/belich">https://github.com/daguilarm/belich</a></p>
            <p><strong>Documentación:</strong> <a href="https://belich.dev">https://belich.dev</a></p>
            <p><strong>Ejemplo:</strong> <a href="https://github.com/daguilarm/belich-dashboard">https://github.com/daguilarm/belich-dashboard</a></p>
        </div>
    </section>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('_layouts.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /Users/daguilarm/Sites/blog/source/projects.blade.php ENDPATH**/ ?>