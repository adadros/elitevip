<!DOCTYPE HTML>

<html>
<head>
    <title>Elite Experience Vip</title>
    <meta charset="utf-8" />
    <!--<meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=no" />-->
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <meta name="description" content="" />
    <meta name="keywords" content="" />
    <!-- Metro 4 -->
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.15.1/css/all.css" integrity="sha384-vp86vTRFVJgpjF9jiIGPEEqYqlDwgyBgEF109VFjmqGmIY/Y4HV4d3Gp2irVfcrp" crossorigin="anonymous">
    <link rel="stylesheet" href="{{asset("css/metro-4.4.3.min.css")}}">
    <link rel="stylesheet" href="{{ asset("css/main.css")}}" />

</head>
<body class="is-preload" id="body-content">

<!-- Header -->
<div data-role="appbar" data-expand-point="md" class="bg-black fg-taupe">
    <a href="{{ url('/') }}" class="brand no-hover">
        <img class="img-responsive" src="{{asset("images/eliteexptext.svg")}}">
    </a>

    <ul class="app-bar-menu bg-black fg-taupe">
        <li><a class="fg-lightTaupe-hover" href="{{route('inicio')}}">Inicio</a></li>
        <li><a class="fg-lightTaupe-hover" href="{{route('proveedores')}}">Proveedores</a></li>
        <li><a class="fg-lightTaupe-hover" href="{{route('colaboradores')}}">Colaboradores</a></li>
        <li><a class="fg-lightTaupe-hover" href="{{route('bolsatrabajo')}}">Bolsa de trabajo</a></li>
        <li><a class="fg-lightTaupe-hover" href="{{route('contacto')}}">Contacto</a></li>
        <li><a class="fg-lightTaupe-hover" href="{{route('registro')}}">Registro</a></li>
    </ul>
</div>



<!-- Nav -->


<!--content yield-->

@yield('content')

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
<script src="{{ asset("js/public.js") }}"></script>

</body>
</html>