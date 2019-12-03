@extends('_layouts.master')

@push('meta')
    <meta property="og:title" content="Contact {{ $page->siteName }}" />
    <meta property="og:type" content="website" />
    <meta property="og:url" content="{{ $page->getUrl() }}"/>
    <meta property="og:description" content="Get in touch with {{ $page->siteName }}" />
    <style>
        .email:before {
            content: "\006a\0068\006f\006e\0040\0067\006d\0061\0069\006c\002e\0063\006f\006d";
        }
    </style>
@endpush

@section('body')
<h1>Contacto</h1>

<p class="mb-8">
    Puedes contactar conmigo mediante:
    <ul>
        <li>Twitter: <a href="https://twitter.com/daguilarm" target="_black">@daguilarm</a></li>
        <li>Email: <span class="email">damian.aguilarm@gmail.com</span></li>
    </ul>
</p>
@stop
