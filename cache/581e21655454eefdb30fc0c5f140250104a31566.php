<div class="flex flex-col mb-4">
    <p class="text-gray-600 font-medium my-2">
        <?php echo e($post->getDate()->format('d/m/Y')); ?>

    </p>

    <h2 class="text-3xl mt-0">
        <a
            href="<?php echo e($post->getUrl()); ?>"
            title="Read more - <?php echo e($post->title); ?>"
            class="<?php echo e($loop->even ? 'text-blue-600' : 'text-gray-600'); ?> font-extrabold"
        ><?php echo e($post->title); ?></a>
    </h2>

    <p class="mb-4 mt-0"><?php echo $post->getExcerpt(200); ?></p>

    <a
        href="<?php echo e($post->getUrl()); ?>"
        title="Read more - <?php echo e($post->title); ?>"
        class="uppercase font-semibold tracking-wide mb-2 sm:text-orange-600"
    >Leer mas...</a>
</div>
<?php /**PATH /Users/daguilarm/Sites/blog/source/_components/post-preview-inline.blade.php ENDPATH**/ ?>