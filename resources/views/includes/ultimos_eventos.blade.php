@if( isset($eventos) )
    <div class="titulo-listados">
        Últimos Eventos
    </div>
    <div class="row">
            @foreach($eventos as $evento)
                <div class="cell-lg-4 cell-md-8 cell-sm-8 cell-fs-12">
                    <div class="evento-list px-2">
                        <div class="img-container rounded">
                            <img src="{{asset('uploads/'.$evento->portada)}}">
                            <div class="image-overlay op-black-low">
                                <div class="pos-absolute pos-center z-5">
                                        <div class="h6">{{$evento->titulo}}</div>
                                        <div>
                                            <a href="{{route('evento_detalle',['id'=>$evento->id])}}" role="button" class="button bg-darkTaupe bg-lightTaupe-hover rounded">Ver más detalles</a>
                                        </div>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            @endforeach

    </div>



@endif

