<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Elite experience vip</title>

        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css?family=Nunito:200,600" rel="stylesheet">

        <!-- Styles -->
        <style>
            html, body {
                background-color: #fff;
                color: #636b6f;
                font-family: 'Nunito', sans-serif;
                font-weight: 200;
                height: 100vh;
                margin: 0;
            }

            .full-height {
                height: 100vh;
            }

            .flex-center {
                align-items: center;
                display: flex;
                justify-content: center;
            }

            .position-ref {
                position: relative;
            }

            .top-right {
                position: absolute;
                right: 10px;
                top: 18px;
            }

            .content {
                text-align: center;
            }

            .title {
                font-size: 48px;
            }

            .responsive-logo{
                width: 100%;
                height: auto;
            }

            .m-b-md {
                margin-bottom: 10px;
            }
        </style>
    </head>
    <body>
       
        
        <div class="flex-center position-ref full-height">
            @if (Route::has('login'))
                <div class="top-right links">
                    @auth
                        <a href="{{ url('/inicio') }}">Home</a>
                    @else
                        <a href="{{ route('loguear') }}">Login</a>

                        @if (Route::has('register'))
                            <a href="{{ route('registro') }}">Registro</a>
                        @endif
                    @endauth
                </div>
            @endif

            <div class="content">
                
                <div class="title m-b-md">
                    Sitio en construcción!..
                </div>
                <div>
                    <img class="responsive-logo" src="{{ asset("public/images/elitevip.jpg")}}" alt="logo">
                </div>

                
                
                
            </div>
        </div>
    </body>
</html>
