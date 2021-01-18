@extends('layouts.app')

@section('content')

    <input type="hidden" id="redirect_after" value="bolsatrabajo" >
    <div class="container mt-15" id="registro-form"  >
        <section>

            <div class="grid">
                <div class="row">
                    <div class="cell-md-12 cell-sm-full fg-lightTaupe p-10">
                        @if($email_send)
                            <div align="center">
                                <h2 class="display-2 p-5">El formulario de bolsa de trabajo no se envió.</h2>
                            </div>
                            <div class="d-flex flex-justify-center">
                                <a class="mt-15 pl-10 pr-10 button shadowed dark fg-white fg-lightTaupe-hover" href="{{route('contacto')}}">Regresar a la bolsa de trabajo</a>
                            </div>
                        @else
                            <div class="row">
                                <div class="cell-md-3 mx-auto">
                                    <img src="{{asset("public/images/elitevip_logo.svg")}}">
                                </div>
                            </div>
                            <div align="center">
                                <h2 class="display-2 p-5">¡Gracias por contactarnos!</h2>
                            </div>
                            <div class="text-center">
                                Hola {{strtoupper($nombre)}}, El formulario de bolsa de trabajo se ha envíado, nosotros nos comunicaremos contigo cuando tengamos algun lugar disponible.
                            </div>


                        @endif


                    </div>
                </div>
            </div>




        </section>
    </div>

@endsection