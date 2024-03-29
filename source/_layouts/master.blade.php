<?php
    $title = $page->title
        ? $page->title
        : 'Programación y diseño web: PHP, Laravel y javascript';

    $og_image = $page->cover_image
        ? $page->baseUrl . '/assets/img/og/'.$page->cover_image
        : $page->baseUrl . '/assets/img/og-image.jpg';
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
        <meta http-equiv="expires" content="86400"/>
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
        <meta name="twitter:card" content="summary_large_image">
        <meta name="twitter:site" content="@daguilarm">
        <meta name="twitter:creator" content="@daguilarm">
        <meta name="twitter:title" content="{{ $title }}">
        <meta name="twitter:description" content="{{ $page->description ?? $page->description ?? $page->siteDescription }}">
        <meta name="twitter:creator" content="@daguilarm">
        <meta name="twitter:domain" content="https://daguilar.dev">
        <meta name="twitter:image" content="{{ $page->baseUrl }}/assets/img/twitter.jpg?refresh={{ rand(1, 1000000000) }}">
        <meta name="twitter:image:alt" content="{{ $page->title }}">
        {{-- Meta tags --}}
        <meta name="msapplication-TileColor" content="#ffffff">
        <meta name="msapplication-TileImage" content="/ms-icon-144x144.png">
        <meta name="theme-color" content="#ffffff">
        <meta name="robots" content="index, follow, max-image-preview:large, max-snippet:-1, max-video-preview:-1">
        {{-- Custom metatags --}}
        @stack('metatags')
        {{-- Links --}}
        <link rel="home" href="{{ $page->baseUrl }}">
        <link rel="alternate" type="application/rss+xml" title="{{ $page->title }}" href="{{ $page->baseUrl.'/rss.xml' }}" />
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
        <link rel="stylesheet" href="{{ mix('css/main.css', 'assets/build') }}">

        {{-- Custom css --}}
        @stack('custom-css')

        {{-- GDPR --}}
        <script type="text/javascript" src="../../../assets/gdpr/gdpr.js"></script>
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

    <body class="flex flex-col justify-between min-h-screen bg-gray-100 text-gray-800 leading-normal">
        
        {{-- Include categories navigation --}}
        @include('_layouts._nav.menu-categories')

        {{-- Github cat --}}
        <a href="https://github.com/daguilarm" rel="noopener noreferrer" target="_blank" class="hidden lg:block float-right z-50" aria-label="Mis proyectos en GitHub"><svg width="80" height="80" viewBox="0 0 250 250" style="fill:#fff; color:#2c5282; position: absolute; top: 0; border: 0; right: 0;" aria-hidden="true"><path d="M0,0 L115,115 L130,115 L142,142 L250,250 L250,0 Z"></path><path d="M128.3,109.0 C113.8,99.7 119.0,89.6 119.0,89.6 C122.0,82.7 120.5,78.6 120.5,78.6 C119.2,72.0 123.4,76.3 123.4,76.3 C127.3,80.9 125.5,87.3 125.5,87.3 C122.9,97.6 130.6,101.9 134.4,103.2" fill="currentColor" style="transform-origin: 130px 106px;" class="octo-arm"></path><path d="M115.0,115.0 C114.9,115.1 118.7,116.5 119.8,115.4 L133.7,101.6 C136.9,99.2 139.9,98.4 142.2,98.6 C133.8,88.0 127.5,74.4 143.8,58.0 C148.5,53.4 154.0,51.2 159.7,51.0 C160.3,49.4 163.2,43.6 171.4,40.1 C171.4,40.1 176.1,42.5 178.8,56.2 C183.1,58.6 187.2,61.8 190.9,65.4 C194.5,69.0 197.7,73.2 200.1,77.6 C213.8,80.2 216.3,84.9 216.3,84.9 C212.7,93.1 206.9,96.0 205.4,96.6 C205.1,102.4 203.0,107.8 198.3,112.5 C181.9,128.9 168.3,122.5 157.7,114.1 C157.9,116.9 156.7,120.9 152.7,124.9 L141.0,136.5 C139.8,137.7 141.6,141.9 141.8,141.8 Z" fill="currentColor" class="octo-body"></path></svg></a><style>.github-corner:hover .octo-arm{animation:octocat-wave 560ms ease-in-out}@keyframes octocat-wave{0%,100%{transform:rotate(0)}20%,60%{transform:rotate(-25deg)}40%,80%{transform:rotate(10deg)}}@media (max-width:500px){.github-corner:hover .octo-arm{animation:none}.github-corner .octo-arm{animation:octocat-wave 560ms ease-in-out}}</style>
        
        {{-- Include menu --}}
        @include('_layouts._nav.menu')

        {{-- Include the main section -> body --}}
        <main role="main" class="flex-auto w-full container mx-auto py-16 px-6 z-20">

            @include('_components.banner')

            @yield('body')

            @include('_components.banner')
        </main>

        {{-- Footer --}}
        @include('_layouts.footer')

        {{-- Scripts --}}
        <script src="{{ mix('js/main.js', 'assets/build') }}"></script>
        @stack('scripts')
        <script>
            gdprCookieNotice({
                    locale: 'es',
                    timeout: 1500, 
                    expiration: 30, 
                    domain: window.location.hostname, 
                    implicit: false, 
                    statement: '/legal/cookies', 
                    analytics: [],
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
