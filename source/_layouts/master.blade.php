<!DOCTYPE html>
<html lang="es">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <meta http-equiv="x-ua-compatible" content="ie=edge">
        <title>{{ $page->siteName }}{{ $page->title ? ' | ' . $page->title : '' }}</title>
        <meta name="description" content="{{ $page->meta_description ?? $page->siteDescription }}">
        <meta property="og:title" content="{{ $page->title ?  $page->title . ' | ' : '' }}{{ $page->siteName }}"/>
        <meta property="og:type" content="website" />
        <meta property="og:url" content="{{ $page->getUrl() }}"/>
        <meta property="og:description" content="{{ $page->siteDescription }}" />
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

{{--         @if ($page->production)
            //
        @endif --}}

        <link href="https://fonts.googleapis.com/css?family=Nunito+Sans:300,300i,400,400i,700,700i,800,800i" rel="stylesheet">
        <link rel="stylesheet" href="{{ mix('css/main.css', 'assets/build') }}">
    </head>

    <body class="flex flex-col justify-between min-h-screen bg-gray-100 text-gray-800 leading-normal font-sans">
        <header id="header" class="flex items-center h-32 shadow-lg" role="banner">
            {{-- Montains --}}
            @include('_layouts.components.montains')
            {{-- header container --}}
            <div class="container flex items-center max-w-8xl mx-auto px-4 lg:px-8">
                {{-- Logo --}}
                <div class="z-20 -mt-20 sm:mt-0">
                    <a href="/" title="{{ $page->siteName }}" class="block sm:hidden absolute top-0 mt-3">El blog de Damián Aguilar</a>
                    <a href="/" title="{{ $page->siteName }}" class="hidden sm:block">
                        <div class="text-lg text-gray-600 p-2">El blog de</div>
                        <div class="text-2xl text-blue-600 p-2 -mt-4">Damián Aguilar</div>
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
        <!-- Global site tag (gtag.js) - Google Analytics -->
{{--         <script async src="https://www.googletagmanager.com/gtag/js?id=UA-46576351-1"></script>
        <script>
          window.dataLayer = window.dataLayer || [];
          function gtag(){dataLayer.push(arguments);}
          gtag('js', new Date());

          gtag('config', 'UA-46576351-1');
        </script> --}}

    </body>
</html>
