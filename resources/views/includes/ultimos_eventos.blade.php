@if( isset($eventos) )
    <div class="titulo-listados">
        Últimos Eventos
    </div>
    <div class="container">
            @foreach($eventos as $evento)
            <div class="row mb-10">
                <div class="cell-lg-6 cell-md-6 cell-sm-8 cell-fs-12">
                    <div class="evento-list px-5">
                        <div class="img-container rounded">
                            <img src="{{asset('public/uploads/'.$evento->portada)}}">
                            <div class="image-overlay op-black-low">
                                <div class="row">
                                    <div class="cell-lg-6 cell-md-6 cell-sm-7 cell-fs-7 op-darkTaupe-hi fg-lightTaupe rounded px-3">
                                        <div class="h6">{{$evento->titulo}}</div>
                                        @if(isset($evento->fechas))
                                            @foreach($evento->fechas as $fecha)
                                                <div class="small"><span class="mif-calendar mr-3"></span> {{$fecha}}</div>
                                            @endforeach

                                        @endif
                                    </div>

                                    <div class="cell-lg-4 cell-md-4 cell-sm-5 cell-fs-5">
                                        <a role="button" class="button bg-primary bg-darkTaupe-hover outline">Ver detalle</a>
                                        <a role="button" class="button bg-success outline">Apartar lugar</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            @endforeach

    </div>



@endif

