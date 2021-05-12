---
title: Información de contacto
description: Contacte con Damián Aguilar a través de email, twitter, github,...
---
@extends('_layouts.master')

@push('custom-css')
    <style>
        .email:before {
            content: attr(data-website) "\0040" attr(data-user);
            unicode-bidi: bidi-override;
            direction: rtl;
        }
    </style>
@endpush

@section('body')
<h1 class="text-blue-800 text-3xl md:text-4xl lg:text-5xl">Contacto</h1>

<p class="mb-8">
    Puedes contactar conmigo mediante:
    <ul>
        <li>Twitter: <a href="https://twitter.com/daguilarm" target="_black" rel="noopener noreferrer">@daguilarm</a></li>
        <li>LinkedIn: <a href="https://www.linkedin.com/in/damian-antonio-aguilar-morales-190606207/?originalSubdomain=es" target="_black" rel="noopener noreferrer">Damián Aguilar</a></li>
        <li>Email: <a href="&#109;&#97;&#105;&#108;&#116;&#111;&#58;%64%61%6D%69%61%6E%2E%61%67%75%69%6C%61%72%6D%40%67%6D%61%69%6C%2E%63%6F%6D"><span class="email" data-user="mraliuga.naimad" data-website="moc.liamg"></span></a></li>
    </ul>
</p>
@stop
