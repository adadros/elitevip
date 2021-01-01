@extends('layouts.app')

@section('content')


    <div class="container mt-15" id="registro-form"  >
        <section>

            <div class="grid">
                <div class="row">
                    <div class="cell-md-12 cell-sm-full fg-lightTaupe p-10">
                        @if($existemail)
                            <div align="center">
                                <h2 class="display-2 p-5">El correo {{$correo}} ya se encuentra registrado.</h2>
                            </div>
                             <div class="d-flex flex-justify-center">
                                <a class="mt-15 pl-10 pr-10 button shadowed dark fg-white fg-lightTaupe-hover" href="{{route('registro')}}">Ir al menú de login</a>
                             </div>
                        @else
                            <div class="row">
                                <div class="cell-md-3 mx-auto">
                                    <img src="{{asset("public/images/elitevip_logo.svg")}}">
                                </div>
                            </div>
                            <div align="center">
                                <h2 class="display-2 p-5">¡Gracias por registrarte!</h2>
                            </div>
                            <div>
                                Hola {{strtoupper($nombre.' '.$apellido)}}, tu registro se ha creado con éxito. Nosotros revisaremos tu información, en caso de ser seleccionado
                                se te enviará un correo con tu usuario y password para que puedas acceder a nuestros eventos.
                            </div>


                        @endif


                    </div>
                </div>
            </div>




        </section>
    </div>

@endsection