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
    <link rel="stylesheet" href="{{asset("css/metro-4.4.3.min.css")}}">
    <link rel="stylesheet" href="{{ asset("css/admin.css")}}" />

</head>
<body class="is-preload" id="body-content">


    @yield('content')



<!-- Scripts -->
<!-- Metro 4 -->
<script src="{{asset("js/metro-4.4.3.min.js")}}"></script>

</body>
</html>