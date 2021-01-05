@if( isset($eventos) )
    <div class="titulo-listados">
        Últimos Eventos
    </div>
    <div class="container">
            @foreach($eventos as $evento)
            <div class="row mb-10">
                <div class="cell-lg-4 cell-md-7 cell-sm-5 cell-fs-10">
                    <div class="evento-list px-5">
                        <div class="img-container rounded">
                            <img src="{{asset('public/uploads/'.$evento->portada)}}">
                            <div class="image-overlay op-black-low">
                                <div class="pos-relative">
                                    <a role="button" class="button fg-lightTaupe bg-darkTaupe-hover z-5 outline">Apartar lugar</a>
                                </div>
                                <div class="text-ellipsis" style="width:400px;">
                                    <?php print $evento->descripcion; ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="cell-lg-3 cell-md-5 cell-sm-5 cell-fs-10 op-darkTaupe-hi fg-lightTaupe rounded px-3">
                    <div class="h6">{{$evento->titulo}}</div>
                    @if(isset($evento->fechas))
                        @foreach($evento->fechas as $fecha)
                            <div class="small"><span class="mif-calendar mr-3"></span> {{$fecha}}</div>
                        @endforeach

                    @endif
                </div>

            </div>
            @endforeach

    </div>



@endif

