<?php
    $title = $page->title
        ? $page->title
        : sprintf('%s. Php, Javascript, Laravel y diseño web.', $page->siteName);

    $og_image = $page->cover_image
        ? 'https://daguilar.dev/assets/img/og/'.$page->cover_image
        : 'https://daguilar.dev/assets/img/og-image.jpg';
?>
<!DOCTYPE html>
<html lang="es">
    <head>
        <meta charset="UTF-8">
        <title>{{ $title }}</title>
        <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <meta name="description" content="{{ $page->meta_description ?? $page->description ?? $page->siteDescription }}">
        <meta name="msvalidate.01" content="7EBAF0830896AD1D4A27E93C37552EDA" />
        {{-- OG --}}
        <meta property="og:title" content="{{ $page->title }}" />
        <meta property="og:type" content="article" />
        <meta property="og:url" content="{{ $page->getUrl() }}"/>
        <meta property="og:description" content="{{ $page->description }}" />
        <meta property="og:locale" content="es_ES">
        <meta property="og:site_name" content="{{ $page->siteName }}">
        <meta property="og:image:width" content="1200" />
        <meta property="og:image:height" content="630" />
        <meta property="og:image" content="{{ $og_image }}" />
        <meta property="og:image:alt" content="{{ $page->title }}" />
        {{-- Twitter OG --}}
        <meta name="twitter:site" content="@daguilarm">
        <meta name="twitter:creator" content="@daguilarm">
        <meta name="twitter:title" content="{{ $title }}">
        <meta name="twitter:description" content="{{ $page->meta_description ?? $page->description ?? $page->siteDescription }}">
        <meta name="twitter:url" content="{{ $page->getUrl() }}">
        <meta name="twitter:card" content="summary_large_image">
        <meta name="twitter:image" content="{{ $og_image }}">
        {{-- Meta tags --}}
        <meta name="msapplication-TileColor" content="#ffffff">
        <meta name="msapplication-TileImage" content="/ms-icon-144x144.png">
        <meta name="theme-color" content="#ffffff">
        <meta name="robots" content="index, follow, max-image-preview:large, max-snippet:-1, max-video-preview:-1">
        {{-- Custom metatags --}}
        @stack('metatags')
        {{-- Links --}}
        <link rel="home" href="{{ $page->baseUrl }}">
        <link rel="alternate" type="application/rss+xml" title="{{ $page->siteName }}" href="{{ $page->baseUrl.'/rss.xml' }}" />
        <link rel="apple-touch-icon" sizes="57x57" href="{{ $page->baseUrl }}/assets/img/favicon/apple-icon-57x57.png">
        <link rel="apple-touch-icon" sizes="60x60" href="{{ $page->baseUrl }}/assets/img/favicon/apple-icon-60x60.png">
        <link rel="apple-touch-icon" sizes="72x72" href="{{ $page->baseUrl }}/assets/img/favicon/apple-icon-72x72.png">
        <link rel="apple-touch-icon" sizes="76x76" href="{{ $page->baseUrl }}/assets/img/favicon/apple-icon-76x76.png">
        <link rel="apple-touch-icon" sizes="114x114" href="{{ $page->baseUrl }}/assets/img/favicon/apple-icon-114x114.png">
        <link rel="apple-touch-icon" sizes="120x120" href="{{ $page->baseUrl }}/assets/img/favicon/apple-icon-120x120.png">
        <link rel="apple-touch-icon" sizes="144x144" href="{{ $page->baseUrl }}/assets/img/favicon/apple-icon-144x144.png">
        <link rel="apple-touch-icon" sizes="152x152" href="{{ $page->baseUrl }}/assets/img/favicon/apple-icon-152x152.png">
        <link rel="apple-touch-icon" sizes="180x180" href="{{ $page->baseUrl }}/assets/img/favicon/apple-icon-180x180.png">
        <link rel="icon" type="image/png" sizes="192x192"  href="{{ $page->baseUrl }}/assets/img/favicon/android-icon-192x192.png">
        <link rel="icon" type="image/png" sizes="32x32" href="{{ $page->baseUrl }}/assets/img/favicon/favicon-32x32.png">
        <link rel="icon" type="image/png" sizes="96x96" href="{{ $page->baseUrl }}/assets/img/favicon/favicon-96x96.png">
        <link rel="icon" type="image/png" sizes="16x16" href="{{ $page->baseUrl }}/assets/img/favicon/favicon-16x16.png">
        <link rel="manifest" href="{{ $page->baseUrl }}/assets/img/favicon/manifest.json">
        <link rel="dns-prefetch" href="//fonts.googleapis.com">
        <link rel="preconnect" href="//fonts.googleapis.com" crossorigin>
        <link href="https://fonts.googleapis.com/css?family=Nunito+Sans:300,300i,400,400i,700,700i,800,800i" rel="stylesheet">
        <link rel="stylesheet" href="{{ mix('css/main.css', 'assets/build') }}">
        {{-- <link rel="canonical" href="https://daguilar.dev"> --}}
        {{-- Custom css --}}
        @stack('custom-css')

        {{-- GDPR --}}
        <script type="text/javascript" src="../../assets/gdpr/gdpr.js"></script>
        <script type="text/javascript" src="../../assets/gdpr/es.js"></script>
        <script>
            document.addEventListener('gdprCookiesEnabled', function (e) {
                if(e.detail.marketing) { //checks if marketing cookies are enabled
                    var divForBanner = document.getElementsByClassName('marketing-banner');
                    var bannerHtml = '<iframe src="https://rcm-eu.amazon-adsystem.com/e/cm?o=30&p=48&l=ur1&category=primeday&banner=0CJQFH890BEJ2EREPQR2&f=ifr&linkID=0dee11051e921f2ae16f919c6515de3b&t=ofertiacom-21&tracking_id=ofertiacom-21" width="728" height="90" scrolling="no" border="0" marginwidth="0" style="border:none;" frameborder="0" sandbox="allow-scripts allow-same-origin allow-popups allow-top-navigation-by-user-activation"></iframe>';
                    
                    for (var i = 0; i < divForBanner.length; i++) {
                        divForBanner[i].innerHTML = bannerHtml;
                    }
                }
            });
        </script>
    </head>

    <body class="flex flex-col justify-between min-h-screen bg-gray-100 text-gray-800 leading-normal font-sans">
        <a href="https://github.com/daguilarm" rel="noopener noreferrer" target="_blank" class="hidden lg:block float-right z-50 github-corner" aria-label="Mis proyectos en GitHub"><svg width="80" height="80" viewBox="0 0 250 250" style="fill:#4a5568; color:#fff; position: absolute; top: 0; border: 0; right: 0;" aria-hidden="true"><path d="M0,0 L115,115 L130,115 L142,142 L250,250 L250,0 Z"></path><path d="M128.3,109.0 C113.8,99.7 119.0,89.6 119.0,89.6 C122.0,82.7 120.5,78.6 120.5,78.6 C119.2,72.0 123.4,76.3 123.4,76.3 C127.3,80.9 125.5,87.3 125.5,87.3 C122.9,97.6 130.6,101.9 134.4,103.2" fill="currentColor" style="transform-origin: 130px 106px;" class="octo-arm"></path><path d="M115.0,115.0 C114.9,115.1 118.7,116.5 119.8,115.4 L133.7,101.6 C136.9,99.2 139.9,98.4 142.2,98.6 C133.8,88.0 127.5,74.4 143.8,58.0 C148.5,53.4 154.0,51.2 159.7,51.0 C160.3,49.4 163.2,43.6 171.4,40.1 C171.4,40.1 176.1,42.5 178.8,56.2 C183.1,58.6 187.2,61.8 190.9,65.4 C194.5,69.0 197.7,73.2 200.1,77.6 C213.8,80.2 216.3,84.9 216.3,84.9 C212.7,93.1 206.9,96.0 205.4,96.6 C205.1,102.4 203.0,107.8 198.3,112.5 C181.9,128.9 168.3,122.5 157.7,114.1 C157.9,116.9 156.7,120.9 152.7,124.9 L141.0,136.5 C139.8,137.7 141.6,141.9 141.8,141.8 Z" fill="currentColor" class="octo-body"></path></svg></a><style>.github-corner:hover .octo-arm{animation:octocat-wave 560ms ease-in-out}@keyframes octocat-wave{0%,100%{transform:rotate(0)}20%,60%{transform:rotate(-25deg)}40%,80%{transform:rotate(10deg)}}@media (max-width:500px){.github-corner:hover .octo-arm{animation:none}.github-corner .octo-arm{animation:octocat-wave 560ms ease-in-out}}</style>
        <header class="flex items-center h-32 shadow-xl bg-blue-700" role="banner">
            {{-- Montains --}}
            {{-- @include('_layouts.components.montains') --}}
            {{-- header container --}}
            <div class="container flex items-center max-w-8xl mx-auto px-4 lg:px-8">
                {{-- Logo --}}
                <div class="z-20 -mt-20 sm:mt-0">
                    <a href="/" title="{{ $page->siteName }}" class="block sm:hidden absolute top-0 mt-3 text-yellow-400">El blog de Damián Aguilar</a>
                    <a href="/" title="{{ $page->siteName }}" class="hidden sm:block">
                        <div class="text-lg text-yellow-400 p-2">El blog de</div>
                        <div class="text-2xl font-bold text-white p-2 -mt-4">Damián Aguilar</div>
                    </a>
                </div>
                {{-- Sky --}}
                @include('_layouts.components.sky')
                {{-- Search --}}
                <div id="vue-search" class="flex flex-1 justify-end items-center relative">
                    <search class="z-50"></search>
                    @include('_nav.menu')
                    @include('_nav.menu-toggle')
                </div>
            </div>
        </header>

        @include('_nav.menu-responsive')

        <main role="main" class="flex-auto w-full container mx-auto py-16 px-6 z-20">

            @include('_components.banner')

            @yield('body')

            @include('_components.banner')
        </main>

        <footer class="w-full flex items-center h-24 bg-white sm:bg-gray-600 sm:text-gray-100 text-center text-sm mt-12 py-4" role="contentinfo">
            <div class="flex-1">
                &copy; Damián Aguilar 2019-{{ date('Y') }} -
                <a href="https://github.com/daguilarm" class="sm:text-gray-100 hover:text-gray-300">
                    Github
                </a> -
                <a href="https://daguilar.dev/blog/rss.xml" class="sm:text-gray-100 hover:text-gray-300">
                    RSS
                </a> -
                <a href="https://daguilar.dev/blog/legal/cookies" class="sm:text-gray-100 hover:text-gray-300">
                    Política de cookies
                </a> -
                <a href="https://daguilar.dev/blog/legal/legal" class="sm:text-gray-100 hover:text-gray-300">
                    Datos legales
                </a> -
                <a href="https://daguilar.dev/blog/legal/privacity" class="sm:text-gray-100 hover:text-gray-300">
                    Aviso de privacidad
                </a>
            </div>
        </footer>

        <script src="{{ mix('js/main.js', 'assets/build') }}"></script>

        @stack('scripts')
        <script>

            gdprCookieNotice({
                    locale: 'es', // si lo cambias debes tener un archivo como el de arriba es.js
                    timeout: 1500, // tiempo de espera
                    expiration: 30, // días de duración de la cookie
                    domain: window.location.hostname, // dominio
                    implicit: false, // debe se false, porque de lo contrario no cumples
                    statement: '/legal/cookies', // url a la política de cookies / legal
                    analytics: [], // aquí el grupo analitica pero hay más en opciones
                    marketing: ['ad-privacy', 'ad-id']
            });

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
