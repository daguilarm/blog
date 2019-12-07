<!DOCTYPE html>
<html lang="es">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <meta http-equiv="x-ua-compatible" content="ie=edge">
        <meta name="description" content="{{ $page->meta_description ?? $page->siteDescription }}">

        <meta property="og:title" content="{{ $page->title ?  $page->title . ' | ' : '' }}{{ $page->siteName }}"/>
        <meta property="og:type" content="website" />
        <meta property="og:url" content="{{ $page->getUrl() }}"/>
        <meta property="og:description" content="{{ $page->siteDescription }}" />

        <title>{{ $page->siteName }}{{ $page->title ? ' | ' . $page->title : '' }}</title>

        <link rel="home" href="{{ $page->baseUrl }}">
        <link href="/blog/feed.atom" type="application/atom+xml" rel="alternate" title="{{ $page->siteName }} Atom Feed">
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
        <meta name="msapplication-TileColor" content="#ffffff">
        <meta name="msapplication-TileImage" content="/ms-icon-144x144.png">
        <meta name="theme-color" content="#ffffff">
        @stack('meta')

        @if ($page->production)
            <!-- Insert analytics code here -->
        @endif

        <link href="https://fonts.googleapis.com/css?family=Nunito+Sans:300,300i,400,400i,700,700i,800,800i" rel="stylesheet">
        <link rel="stylesheet" href="{{ mix('css/main.css', 'assets/build') }}">
    </head>

    <body class="flex flex-col justify-between min-h-screen bg-grey-lightest text-grey-darkest leading-normal font-sans">
        <header id="header" class="flex items-center h-32 shadow-lg" role="banner">
            <div class="sun">
                <div class="ray_box">
                    <div class="ray ray1"></div>
                    <div class="ray ray2"></div>
                    <div class="ray ray3"></div>
                    <div class="ray ray4"></div>
                    <div class="ray ray5"></div>
                    <div class="ray ray6"></div>
                    <div class="ray ray7"></div>
                    <div class="ray ray8"></div>
                    <div class="ray ray9"></div>
                    <div class="ray ray10"></div>
                </div>
            </div>
            <div class="container flex items-center max-w-4xl mx-auto px-4 mb-20 z-20">
                <a href="/" title="{{ $page->siteName }}">
                    <div class="text-xl text-grey-dark p-2 w-40">El blog de</div>
                    <div class="text-2xl text-blue-dark p-2 w-40 -mt-2">Damián Aguilar</div>
                </a>
                <div id="vue-search" class="flex flex-1 justify-end items-center">
                    <search></search>

                    @include('_nav.menu')

                    @include('_nav.menu-toggle')
                </div>
            </div>
            <svg class="h-32" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 100 100" preserveAspectRatio="none">
                <polygon id="gradient-2" points="0,0 15,100 33,21 45,100 50,75 55,100 72,20 85,100 95,50 100,80 100,100 0,100" />
            </svg>
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 100 100" preserveAspectRatio="none">
                <polygon id="gradient-1" points="0,0 30,100 65,21 90,100 100,75 100,100 0,100"/>
                <linearGradient id="polygon-gradient-1">
                    <stop offset="0" stop-color="#a0aec0"/>
                    <stop offset="1" stop-color="#718096"/>
                </linearGradient>
                <linearGradient id="polygon-gradient-2">
                    <stop offset="0" stop-color="#cbd5e0"/>
                    <stop offset="1" stop-color="#4a5568"/>
                    <stop offset="2" stop-color="#a0aec0"/>
                </linearGradient>
            </svg>
        </header>

        @include('_nav.menu-responsive')

        <main role="main" class="flex-auto w-full container max-w-xl mx-auto py-16 px-6">
            @yield('body')
        </main>

        <footer class="bg-white text-center text-sm mt-12 py-4" role="contentinfo">
            <ul class="flex flex-col md:flex-row justify-center list-reset">
                <li class="md:mr-2">
                    &copy; Damián Aguilar {{ date('Y') }}.
                </li>
            </ul>
        </footer>

        <script src="{{ mix('js/main.js', 'assets/build') }}"></script>
        @stack('scripts')
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                var linksTargetBlank = document.querySelectorAll('.link-out');
                for (var i = 0; i < linksTargetBlank.length; i++) {
                    linksTargetBlank[i].target = "_blank";
                }
            }, false);
        </script>
    </body>
</html>
