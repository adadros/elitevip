@extends('layouts.admin')

@section('content')

    <div class="grid p-10">
        <div class="row p-5">
            <div class="cell-md-4 cell-sm-4 cell-fs-12">
                <div class="d-flex flex-justify-start-md flex-justify-start-sm flex-justify-center-fs">
                    <a role="button" href="{{route('admin_secciones')}}" class="button bg-black shadowed fg-lightTaupe"><span class="mif-backspace icon mr-2"></span> Regresar al listado</a>
                </div>
            </div>

            <div class="cell-md-12">
                @if($editable)
                    <h2>Editar sección</h2>
                @else
                    <h2>Nueva sección</h2>
                @endif


                <div class="row">

                    <div class="cell-md-10 cell-sm-10 cell-fs-12">
                        <div class="form-group">
                            <div class="row">
                                <div class="cell-md-6 cell-sm-8 cell-fs-10">
                                    <label>Tipo</label>
                                    @if( isset($seccion) )
                                        <input type="hidden" id="seccion_selected" value="{{$seccion->tipo}}">
                                    @endif
                                    <select id="tipo" name="tipo" data-role="select" >
                                        @foreach($lugares as $lugar)
                                            <option value="{{$lugar->id}}">{{$lugar->nombre}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                        </div>
                        <div class="form-group">
                            <label>Nombre de sección</label>
                            <input data-size="300" id="nombre" name="nombre" type="text" data-role="input" value="{{isset($seccion) ? $seccion->nombre : ''}}">
                        </div>
                    </div>

                </div>
                <div class="border border-bottom-none border-left-none border-right-none bd-lightTaupe py-5 d-flex flex-justify-center my-4">
                    @if($editable)
                        <button role="button" onclick="updateSeccion({{$id}}) " class="button bg-green shadowed fg-white large">Actualizar <span class="ml-3 mif-floppy-disk"></span></button>
                    @else
                        <button role="button" onclick="saveSeccion()" class="button bg-green shadowed fg-white large">Guardar <span class="ml-3 mif-floppy-disk"></span></button>
                    @endif
                </div>

            </div>
        </div>
    </div>






@endsection
