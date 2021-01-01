@extends('layouts.email')

@section('content')
<div class="row">
    <div>
        <img class="img-responsive" src="{{asset('/public/images/elitevip.jpg')}}" >
    </div>
    <div class="cell-md-6">
        <h3>Hola {{$detalle['nombre']}}, bienvenido a Elite Experience Vip</h3>

        <div>
            Ya eres un usuario aprobado!, para iniciar sesión entra a <a href="{{route('loguear')}}" role="button" class="button bg-darkTaupe fg-white small">Iniciar sesión</a>
            con los datos de usuario y contraseña adjuntados abajo:
        </div>

        <div>
            Usuario: {{$detalle['email']}}<br>
            Password: {{ $detalle['password'] }}
        </div>


    </div>



</div>
@endsection
