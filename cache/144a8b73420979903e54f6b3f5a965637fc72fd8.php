<?php $__env->startPush('meta'); ?>
    <?php
        $page->title = 'Listado de artículos sobre programación y diseño web';
        $page->description = 'Artículos sobre diseño web y programación. Centrado en php, laravel, javascript, vuejs, html5, css,...';
    ?>
    <meta property="og:title" content="<?php echo e($page->siteName); ?> Blog" />
    <meta property="og:type" content="website" />
    <meta property="og:url" content="<?php echo e($page->getUrl()); ?>"/>
    <meta property="og:description" content="Listado de artículos y entradas del <?php echo e($page->siteName); ?>" />
<?php $__env->stopPush(); ?>

<?php $__env->startSection('body'); ?>
    <h1 class="text-blue-800 text-3xl md:text-4xl lg:text-5xl">Últimos artículos</h1>

    <hr class="border-b my-6">

    <?php $__currentLoopData = $pagination->items; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $post): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <?php echo $__env->make('_components.post-preview-inline', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

        <?php if($post != $pagination->items->last()): ?>
            <hr class="border-b my-6">
        <?php endif; ?>
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

    <?php if($pagination->pages->count() > 1): ?>
        <nav class="flex text-base my-8">
            <?php if($previous = $pagination->previous): ?>
                <a
                    href="<?php echo e($previous); ?>"
                    title="Previous Page"
                    class="bg-gray-200 hover:bg-gray-400 rounded mr-3 px-5 py-3"
                >&LeftArrow;</a>
            <?php endif; ?>

            <?php $__currentLoopData = $pagination->pages; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $pageNumber => $path): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <a
                    href="<?php echo e($path); ?>"
                    title="Go to Page <?php echo e($pageNumber); ?>"
                    class="bg-gray-200 hover:bg-gray-400 text-blue-darker rounded mr-3 px-5 py-3 <?php echo e($pagination->currentPage == $pageNumber ? 'text-blue-dark' : ''); ?>"
                ><?php echo e($pageNumber); ?></a>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

            <?php if($next = $pagination->next): ?>
                <a
                    href="<?php echo e($next); ?>"
                    title="Next Page"
                    class="bg-gray-200 hover:bg-gray-400 rounded mr-3 px-5 py-3"
                >&RightArrow;</a>
            <?php endif; ?>
        </nav>
    <?php endif; ?>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('_layouts.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /Users/daguilarm/Sites/blog/cache/a0038bcc22d66b99ad17794989c2041dc2ee2979.blade.php ENDPATH**/ ?>