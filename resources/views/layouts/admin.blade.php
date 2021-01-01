<!DOCTYPE HTML>

<html>
<head>
    <title>Elite Experience Vip</title>
    <meta charset="utf-8" />
    <!--<meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=no" />-->
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <meta name="description" content="" />
    <meta name="keywords" content="" />
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <!-- Metro 4 -->
    <link rel="stylesheet" href="{{asset("public/css/metro-4.4.3.min.css")}}">
    <link rel="stylesheet" href="{{ asset("public/css/admin.css")}}" />

</head>
<body class="is-preload" id="body-content">

<!-- Header -->

<aside class="sidebar pos-absolute z-2 h-100"
       data-role="sidebar"
       data-toggle="#sidebar-toggle-3"
       id="sidebar"
       data-shift=".shifted-content"
       data-static-shift=".shifted-content"
       data-static="md"


>





    <div class="sidebar-header" data-image="{{asset('public/images/dj_banner.jpg')}}">
        <a href="/" class="fg-white sub-action d-none-md"
           onclick="Metro.sidebar.close('#sidebar'); return false;">
            <span class="mif-arrow-left mif-2x"></span>
        </a>
        <div class="avatar bg-black">
            <img class="img-responsive" src="{{asset('public/images/elitevip.svg')}}">
        </div>
        <span class="title bg-black fg-white px-2">PERFIL DE ADMINISTRADOR</span>
        <span class="subtitle bg-black fg-white px-2">{{     $profile['nombre'].' '.$profile['apellido'] }} </span>

    </div>
    <ul class="sidebar-menu">
        <li class="group-title">Principal</li>
        <li class="{{ (request()->is('admin/secciones')) ? 'active bg-taupe' : '' }}"><a class="fg-black-hover" href="{{route('admin_secciones')}}"><span class="mif-new-tab icon"></span>Secciones</a></li>
        <li class="{{ (request()->is('admin/paquetes')) ? 'active bg-taupe' : '' }}"><a class="fg-black-hover" href="{{route('admin_paquetes')}}"><span class="mif-tags icon"></span>Paquetes</a></li>
        <li class="{{ (request()->is('admin/eventos')) ? 'active bg-taupe' : '' }}"><a class="fg-black-hover" href="{{route('admin_eventos')}}"><span class="mif-event-available icon"></span>Eventos</a></li>
        <li class="{{ (request()->is('admin/pagos')) ? 'active bg-taupe' : '' }}"><a class="fg-black-hover" href="{{route('admin_pagos')}}"><span class="mif-credit-card icon"></span>Pagos</a></li>
        <li class="{{ (request()->is('admin/usuarios')) ? 'active bg-taupe' : '' }}"><a class="fg-black-hover" href="{{route('admin_usuarios')}}"><span class="mif-user icon"></span>Usuarios</a></li>
        <li class="group-title">Configuración</li>
        <li  class="{{ (request()->is('admin/opciones')) ? 'active bg-taupe' : '' }}"><a class="fg-black-hover" href="{{route('admin_opciones')}}"><span class="mif-cogs icon"></span>Opciones</a></li>
        <li class="{{ (request()->is('admin/perfil')) ? 'active bg-taupe' : '' }}"><a class="fg-black-hover" href="{{route('admin_perfil')}}"><span class="mif-profile icon"></span>Perfil</a></li>
        <li class="divider"></li>
        <li>
            <a  href="{{ route('logout') }}"  onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                {{ __('Salir') }}<span class="mif-exit icon"></span>
            </a>
            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                @csrf
            </form>
        </li>
    </ul>
</aside>




<div class="shifted-content h-100 p-ab">
    <div class="app-bar pos-absolute bg-black z-1" data-role="appbar">
        <button class="app-bar-item c-pointer d-none-md" id="sidebar-toggle-3">
            <span class="mif-menu mif-5x fg-white"></span>
        </button>
        <div class="p-5 ml-5 fg-lightTaupe">PANEL DE ADMINISTRACION</div>
    </div>

<!-- Nav -->


<!--content yield-->

@yield('content')


</div>
<!-- Scripts -->
<!-- Metro 4 -->
<script src="{{asset("public/js/metro-4.4.3.min.js")}}"></script>
<script src="{{ asset("public/js/jquery.min.js") }}"></script>
<script src="{{ asset("public/js/moment.js") }}"></script>
<script src="https://cdn.tiny.cloud/1/pj8ectsoe9ddblad8jgdntgc9pq2ch5kfs2qnetd3bsyczrp/tinymce/5/tinymce.min.js" referrerpolicy="origin"></script>
<script>
    tinymce.init({
        selector:'textarea.simple',
        theme: 'silver',
        menubar:false
    });
    tinymce.init({
        selector:'textarea.editor',
        theme:'silver',

    });

</script>

<script src="{{ asset("public/js/admin.js") }}"></script>

</body>
</html>