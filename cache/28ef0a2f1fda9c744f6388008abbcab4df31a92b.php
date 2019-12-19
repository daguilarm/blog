<?php $__env->startPush('meta'); ?>
    <meta property="og:title" content="<?php echo e($page->title); ?>" />
    <meta property="og:type" content="article" />
    <meta property="og:url" content="<?php echo e($page->getUrl()); ?>"/>
    <meta property="og:description" content="<?php echo e($page->description); ?>" />
<?php $__env->stopPush(); ?>

<?php $__env->startSection('body'); ?>
    <?php if($page->cover_image): ?>
        <div class="w-full flex justify-center">
            <img src="<?php echo e($page->cover_image); ?>" alt="<?php echo e($page->title); ?> cover image" class="mb-2">
        </div>
    <?php endif; ?>

    <h1 class="leading-none mb-6 text-blue-800 text-3xl md:text-4xl lg:text-5xl"><?php echo e($page->title); ?></h1>

    <p class="text-gray-600 text-xl md:mt-0"><?php echo e($page->author); ?>  •  <?php echo e(date('d/m/Y', $page->date)); ?></p>

    <?php if($page->categories): ?>
        <?php $__currentLoopData = $page->categories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $i => $category): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <a
                href="<?php echo e('/blog/categories/' . $category); ?>"
                title="View posts in <?php echo e($category); ?>"
                class="inline-block bg-blue-200 hover:bg-blue-400 leading-loose tracking-wide text-blue-600 hover:text-white uppercase text-xs font-semibold rounded mr-4 px-3 pt-px"
            ><?php echo e($category); ?></a>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    <?php endif; ?>

    <div class="border-b border-blue-200 mb-10 pb-4" v-pre>
        <?php echo $__env->yieldContent('content'); ?>
    </div>

    <nav class="flex justify-between text-sm md:text-base">
        <div>
            <?php if($next = $page->getNext()): ?>
                <a href="<?php echo e($next->getUrl()); ?>" title="Older Post: <?php echo e($next->title); ?>">
                    &LeftArrow; <?php echo e($next->title); ?>

                </a>
            <?php endif; ?>
        </div>

        <div>
            <?php if($previous = $page->getPrevious()): ?>
                <a href="<?php echo e($previous->getUrl()); ?>" title="Newer Post: <?php echo e($previous->title); ?>">
                    <?php echo e($previous->title); ?> &RightArrow;
                </a>
            <?php endif; ?>
        </div>
    </nav>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('_layouts.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /Users/daguilarm/Sites/blog/source/_layouts/post.blade.php ENDPATH**/ ?>