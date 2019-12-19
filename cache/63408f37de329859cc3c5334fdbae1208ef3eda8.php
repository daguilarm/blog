<!DOCTYPE html>
<html lang="es">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <meta http-equiv="x-ua-compatible" content="ie=edge">
        <title><?php echo e($page->title); ?> | <?php echo e($page->siteName); ?></title>
        <meta name="description" content="<?php echo e($page->meta_description ?? $page->description ?? $page->siteDescription); ?>">
        <meta property="og:title" content="<?php echo e($page->title ?  $page->title . ' | ' : ''); ?><?php echo e($page->siteName); ?>"/>
        <meta property="og:type" content="website" />
        <meta property="og:url" content="<?php echo e($page->getUrl()); ?>"/>
        <meta property="og:description" content="<?php echo e($page->siteDescription); ?>" />
        <link rel="home" href="<?php echo e($page->baseUrl); ?>">
        <link href="/blog/feed.atom" type="application/atom+xml" rel="alternate" title="<?php echo e($page->siteName); ?> Atom Feed">
        <link rel="apple-touch-icon" sizes="57x57" href="<?php echo e($page->baseUrl); ?>/assets/img/favicon/apple-icon-57x57.png">
        <link rel="apple-touch-icon" sizes="60x60" href="<?php echo e($page->baseUrl); ?>/assets/img/favicon/apple-icon-60x60.png">
        <link rel="apple-touch-icon" sizes="72x72" href="<?php echo e($page->baseUrl); ?>/assets/img/favicon/apple-icon-72x72.png">
        <link rel="apple-touch-icon" sizes="76x76" href="<?php echo e($page->baseUrl); ?>/assets/img/favicon/apple-icon-76x76.png">
        <link rel="apple-touch-icon" sizes="114x114" href="<?php echo e($page->baseUrl); ?>/assets/img/favicon/apple-icon-114x114.png">
        <link rel="apple-touch-icon" sizes="120x120" href="<?php echo e($page->baseUrl); ?>/assets/img/favicon/apple-icon-120x120.png">
        <link rel="apple-touch-icon" sizes="144x144" href="<?php echo e($page->baseUrl); ?>/assets/img/favicon/apple-icon-144x144.png">
        <link rel="apple-touch-icon" sizes="152x152" href="<?php echo e($page->baseUrl); ?>/assets/img/favicon/apple-icon-152x152.png">
        <link rel="apple-touch-icon" sizes="180x180" href="<?php echo e($page->baseUrl); ?>/assets/img/favicon/apple-icon-180x180.png">
        <link rel="icon" type="image/png" sizes="192x192"  href="<?php echo e($page->baseUrl); ?>/assets/img/favicon/android-icon-192x192.png">
        <link rel="icon" type="image/png" sizes="32x32" href="<?php echo e($page->baseUrl); ?>/assets/img/favicon/favicon-32x32.png">
        <link rel="icon" type="image/png" sizes="96x96" href="<?php echo e($page->baseUrl); ?>/assets/img/favicon/favicon-96x96.png">
        <link rel="icon" type="image/png" sizes="16x16" href="<?php echo e($page->baseUrl); ?>/assets/img/favicon/favicon-16x16.png">
        <link rel="manifest" href="<?php echo e($page->baseUrl); ?>/assets/img/favicon/manifest.json">
        <meta name="msapplication-TileColor" content="#ffffff">
        <meta name="msapplication-TileImage" content="/ms-icon-144x144.png">
        <meta name="theme-color" content="#ffffff">
        <?php echo $__env->yieldPushContent('meta'); ?>



        <link href="https://fonts.googleapis.com/css?family=Nunito+Sans:300,300i,400,400i,700,700i,800,800i" rel="stylesheet">
        <link rel="stylesheet" href="<?php echo e(mix('css/main.css', 'assets/build')); ?>">
    </head>

    <body class="flex flex-col justify-between min-h-screen bg-gray-100 text-gray-800 leading-normal font-sans">
        <a href="https://github.com/daguilarm" target="_blank" class="hidden lg:block float-right z-50 github-corner" aria-label="Mis proyectos en GitHub"><svg width="80" height="80" viewBox="0 0 250 250" style="fill:#4a5568; color:#fff; position: absolute; top: 0; border: 0; right: 0;" aria-hidden="true"><path d="M0,0 L115,115 L130,115 L142,142 L250,250 L250,0 Z"></path><path d="M128.3,109.0 C113.8,99.7 119.0,89.6 119.0,89.6 C122.0,82.7 120.5,78.6 120.5,78.6 C119.2,72.0 123.4,76.3 123.4,76.3 C127.3,80.9 125.5,87.3 125.5,87.3 C122.9,97.6 130.6,101.9 134.4,103.2" fill="currentColor" style="transform-origin: 130px 106px;" class="octo-arm"></path><path d="M115.0,115.0 C114.9,115.1 118.7,116.5 119.8,115.4 L133.7,101.6 C136.9,99.2 139.9,98.4 142.2,98.6 C133.8,88.0 127.5,74.4 143.8,58.0 C148.5,53.4 154.0,51.2 159.7,51.0 C160.3,49.4 163.2,43.6 171.4,40.1 C171.4,40.1 176.1,42.5 178.8,56.2 C183.1,58.6 187.2,61.8 190.9,65.4 C194.5,69.0 197.7,73.2 200.1,77.6 C213.8,80.2 216.3,84.9 216.3,84.9 C212.7,93.1 206.9,96.0 205.4,96.6 C205.1,102.4 203.0,107.8 198.3,112.5 C181.9,128.9 168.3,122.5 157.7,114.1 C157.9,116.9 156.7,120.9 152.7,124.9 L141.0,136.5 C139.8,137.7 141.6,141.9 141.8,141.8 Z" fill="currentColor" class="octo-body"></path></svg></a><style>.github-corner:hover .octo-arm{animation:octocat-wave 560ms ease-in-out}@keyframes  octocat-wave{0%,100%{transform:rotate(0)}20%,60%{transform:rotate(-25deg)}40%,80%{transform:rotate(10deg)}}@media (max-width:500px){.github-corner:hover .octo-arm{animation:none}.github-corner .octo-arm{animation:octocat-wave 560ms ease-in-out}}</style>
        <header id="header" class="flex items-center h-32 shadow-lg" role="banner">
            
            <?php echo $__env->make('_layouts.components.montains', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
            
            <div class="container flex items-center max-w-8xl mx-auto px-4 lg:px-8">
                
                <div class="z-20 -mt-20 sm:mt-0">
                    <a href="/" title="<?php echo e($page->siteName); ?>" class="block sm:hidden absolute top-0 mt-3 text-gray-600">El blog de Damián Aguilar</a>
                    <a href="/" title="<?php echo e($page->siteName); ?>" class="hidden sm:block">
                        <div class="text-lg text-gray-700 p-2">El blog de</div>
                        <div class="text-2xl font-bold text-orange-500 p-2 -mt-4">Damián Aguilar</div>
                    </a>
                </div>
                
                <?php echo $__env->make('_layouts.components.sky', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                
                <div id="vue-search" class="flex flex-1 justify-end items-center relative">
                    <search class="z-50"></search>
                    <?php echo $__env->make('_nav.menu', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                    <?php echo $__env->make('_nav.menu-toggle', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                </div>
            </div>
        </header>

        <?php echo $__env->make('_nav.menu-responsive', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

        <main role="main" class="flex-auto w-full container mx-auto py-16 px-6 z-20">
            <?php echo $__env->yieldContent('body'); ?>
        </main>

        <footer class="w-full flex items-center h-24 bg-white sm:bg-gray-600 sm:text-gray-100 text-center text-sm mt-12 py-4" role="contentinfo">
            <div class="flex-1">
                &copy; Damián Aguilar <?php echo e(date('Y')); ?> -
                <a href="https://github.com/daguilarm" class="sm:text-gray-100 hover:text-gray-300">
                    Github
                </a> -
                <a href="https://belich.dev" class="sm:text-gray-100 hover:text-gray-300">
                    Belich admin
                </a>
            </div>
        </footer>

        <script src="<?php echo e(mix('js/main.js', 'assets/build')); ?>"></script>
        <?php echo $__env->yieldPushContent('scripts'); ?>
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                var linksTargetBlank = document.querySelectorAll('.link-out');
                for (var i = 0; i < linksTargetBlank.length; i++) {
                    linksTargetBlank[i].target = "_blank";
                    linksTargetBlank[i].rel = "noopener";
                }
            }, false);
        </script>


    </body>
</html>
<?php /**PATH /Users/daguilarm/Sites/blog/source/_layouts/master.blade.php ENDPATH**/ ?>