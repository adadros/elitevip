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
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.15.1/css/all.css" integrity="sha384-vp86vTRFVJgpjF9jiIGPEEqYqlDwgyBgEF109VFjmqGmIY/Y4HV4d3Gp2irVfcrp" crossorigin="anonymous">
    <link rel="stylesheet" href="{{asset("css/metro-4.4.3.min.css")}}">
    <link rel="stylesheet" href="{{ asset("css/main.css")}}" />

</head>
<body class="is-preload" id="body-content">

<!-- Header -->
<div data-role="appbar" data-expand-point="md" class="bg-black fg-taupe">

    <a href="#" class="brand no-hover">
        <button class="app-bar-item border bg-darkTaupe c-pointer d-none-md mr-2" id="sidebar-toggle-3">
            <span class="mif-user mif-2x  fg-lightTaupe"></span>
        </button>
        <div class="w-80"><img class="img-responsive" src="{{asset("public/images/eliteexptext.svg")}}"></div>
    </a>


    <ul class="app-bar-menu bg-black fg-taupe">
        <li><a class="fg-lightTaupe-hover" href="{{route('inicio')}}">Inicio</a></li>
        <li><a class="fg-lightTaupe-hover" href="{{route('proveedores')}}">Proveedores</a></li>
        <li><a class="fg-lightTaupe-hover" href="{{route('colaboradores')}}">Colaboradores</a></li>
        <li><a class="fg-lightTaupe-hover" href="{{route('bolsatrabajo')}}">Bolsa de trabajo</a></li>
        <li><a class="fg-lightTaupe-hover" href="{{route('eventos')}}">Eventos</a></li>
        <li><a class="fg-lightTaupe-hover" href="{{route('contacto')}}">Contacto</a></li>
    </ul>

</div>
<div class="row pos-relative pt-200">

    <aside class="sidebar h-100 op-black-low fg-lightTaupe"
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


            <span class="title bg-black fg-white px-2">PERFIL DE USUARIOS</span>
            <span class="subtitle bg-black fg-white px-2">@if(session('profile')) {{ session('profile')['nombre'] }} {{  session('profile')['apellido']  }}  @else     @endif</span>

        </div>
        <ul class="sidebar-menu fg-taupe">
            <li class="group-title fg-darkTaupe">Principal</li>
            <li><a class="fg-lightTaupe-hover" href="#"><span class="mif-event-available icon"></span>Mis eventos</a></li>
            <li><a class="fg-lightTaupe-hover" href="#"><span class="mif-shop icon"></span>Mis compras</a></li>
            <li class="group-title fg-darkTaupe">Configuración</li>
            <!--<li  class=""><a class="fg-black-hover" href="{{route('admin_opciones')}}"><span class="mif-cogs icon"></span>Opciones</a></li>-->
            <li><a class="fg-lightTaupe-hover" href="#"><span class="mif-user icon"></span>Mi perfil</a></li>
            <li class="divider bg-darkTaupe"></li>
            <li>
                <a class="fg-lightTaupe-hover"  href="{{ route('logout') }}"  onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                    {{ __('Salir') }}<span class="mif-exit icon"></span>
                </a>
                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                    @csrf
                        </form>
            </li>
        </ul>
    </aside>




    <div class="shifted-content h-100 p-ab">
        <!-- Nav -->


        <!--content yield-->

        @yield('content')


    </div>



</div>

        <!-- Footer -->
<!--footer id="footer">
    <div class="inner">
        <div class="content">

            <section>
                <h4>Nuestras redes</h4>
                <ul class="plain">
                    <li><a href="#"><i class="icon fa-twitter">&nbsp;</i>Twitter</a></li>
                    <li><a href="#"><i class="icon fa-facebook">&nbsp;</i>Facebook</a></li>
                    <li><a href="#"><i class="icon fa-instagram">&nbsp;</i>Instagram</a></li>
                    <li><a href="#"><i class="icon fa-github">&nbsp;</i>Github</a></li>
                </ul>
            </section>
        </div>
        <div class="copyright">
            &copy; Web design by <a href="http://animotion.com.mx" target="_blank">animotion</a>.
        </div>
    </div>
</footer-->

<!-- Scripts -->
<!-- Metro 4 -->
<script src="{{asset("js/metro-4.4.3.min.js")}}"></script>
<script src="{{ asset("js/jquery.min.js") }}"></script>
<script src="{{ asset("js/main.js") }}"></script>

</body>
</html>