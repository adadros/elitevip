@extends('layouts.admin')

@section('content')

    <div class="grid p-10">
        <div class="row p-5">
            <div class="cell-md-4 cell-sm-4 cell-fs-12">
                <div class="d-flex flex-justify-start-md flex-justify-start-sm flex-justify-center-fs">
                    <a role="button" href="{{route('admin_paquetes')}}" class="button bg-black shadowed fg-lightTaupe"><span class="mif-backspace icon mr-2"></span> Regresar al listado</a>
                </div>
            </div>

            <div class="cell-md-12">
                @if($editable)
                    <h2>Editar paquete</h2>
                @else
                    <h2>Nuevo paquete</h2>
                @endif


                <div class="row">
                    <div class="cell-md-10 cell-sm-10 cell-fs-12">
                        <div class="form-group">
                            <label>Nombre</label>
                            <input data-size="300" id="nombre" name="nombre" type="text" data-role="input" value="{{isset($paquete) ? $paquete->nombre : ''}}">
                        </div>

                        <div class="form-group">
                            <label>Divisa</label>
                            @if( isset($paquete) )
                                <input type="hidden" id="paquete_selected" value="{{$paquete->divisa}}">
                            @endif
                            <div class="row">
                                <div class="col-md-5 col-sm-8 col-fs-12">
                                <select id="divisa" name="divisa" data-role="select">
                                @if(isset($divisas))
                                    @foreach($divisas as $divisa)
                                        <option value="{{$divisa->clave}}">{{$divisa->descripcion}}</option>
                                    @endforeach
                                @endif
                                </select>
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <label>Precio</label>
                            <input data-size="250" id="precio" name="precio" value="{{isset($paquete) ? $paquete->precio : ''}}" type="number" data-role="input">
                        </div>

                        <div class="form-group">
                            <label>Cantidad de personas</label>
                            <div class="row">
                                <div class="cell-md-4 cell-sm-6 cell-fs-8">
                                    <input id="personas" name="personas" data-min-value="1" type="number" value="{{isset($paquete) ? $paquete->personas : 1}}" class="small" data-role="spinner" data-step="1">
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
                <div class="border border-bottom-none border-left-none border-right-none bd-lightTaupe py-5 d-flex flex-justify-center my-4">
                    @if($editable)
                        <button role="button" onclick="updatePaquete({{$id}}) " class="button bg-green shadowed fg-white large">Actualizar <span class="ml-3 mif-floppy-disk"></span></button>
                    @else
                        <button role="button" onclick="savePaquete()" class="button bg-green shadowed fg-white large">Guardar <span class="ml-3 mif-floppy-disk"></span></button>
                    @endif
                </div>

            </div>
        </div>
    </div>






@endsection
