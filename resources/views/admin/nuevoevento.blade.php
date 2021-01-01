@extends('layouts.admin')

@section('content')

    <div class="grid p-10">
        <div class="row p-5">
            <div class="cell-md-4 cell-sm-4 cell-fs-12">
                <div class="d-flex flex-justify-start-md flex-justify-start-sm flex-justify-center-fs">
                    <a role="button" href="{{route('admin_eventos')}}" class="button bg-black shadowed fg-lightTaupe"><span class="mif-backspace icon mr-2"></span> Regresar al listado</a>
                </div>
            </div>

            <div class="cell-md-12">
                <h2>Nuevo evento</h2>

                    <div class="row">
                        <div class="cell-md-8 cell-sm-6">
                            <div class="form-group">
                                <label>Titulo</label>
                                <input id="titulo" name="titulo" type="text" data-role="input">
                            </div>
                            <div class="form-group">
                                <label>Descripción</label>
                                <textarea id="descripcion" name="descripcion" class="simple"> </textarea>
                            </div>

                            <div class="form-group">
                                <h4>Configurar paquetes y secciones</h4>
                                <a role="button" onclick="addSeccionInEvent()" class="mx-auto button bg-darkTaupe shadowed fg-white mt-5" id="addseccion_event">  Agregar sección <span class="mif-add"></span> </a>

                                <ul id="secciones_list" class="d-none">
                                    @if(isset($secciones))
                                        @foreach($secciones as $seccion)
                                            <li data-value="{{$seccion->id}}">{{$seccion->nombre}}</li>
                                        @endforeach
                                    @endif
                                </ul>
                                <ul id="paquetes_list" class="d-none">
                                    @if(isset($paquetes))
                                        @foreach($paquetes as $paquete)
                                            <li data-value="{{$paquete->id}}">{{$paquete->nombre}}</li>
                                        @endforeach
                                    @endif
                                </ul>

                                <div class="row" id="container_secciones">

                                </div>



                            </div>

                        </div>
                        <div class="cell-md-4 cell-sm-6 p-10-md p-5-sm">
                            <div class="form-group">
                                <div class="row">
                                    <div class="cell-md-6 cell-sm-6 cell-fs-12">
                                        <label>Portada </label>
                                    </div>
                                    <div class="cell-md-6 cell-sm-6 cell-fs-12">
                                        <a role="button" onclick="openDialogUploadPortada()" class="mx-auto-fs ml-10 button bg-black shadowed fg-lightTaupe" id="uploadPortada">Subir imagen</a>
                                    </div>
                                </div>

                                <div id="preview_portada" class="mt-5 border-1 bd-lightTaupe border-dashed" style="min-width:200px; min-height:30px;">
                                </div>

                            </div>

                            <div class="form-group">
                                <label>Calendario de fechas</label>
                                <div id="fechas" data-role="calendar"
                                     data-multi-select="true"
                                     data-input-format="dd/mm/yyyy"
                                     data-cls-calendar-header="bg-darkTaupe"
                                     data-cls-selected="bg-taupe fg-white"
                                     data-cls-today="bg-black fg-white"
                                     data-cls-today-button="d-none"
                                     data-cls-clear-button="alert"
                                     data-cls-cancel-button="d-none"
                                     data-cls-done-button="d-none"
                                     data-show-footer="true"
                                     data-locale="es-MX" ></div>

                            </div>

                        </div>
                    </div>
                    <div class="border border-bottom-none border-left-none border-right-none bd-lightTaupe py-5 d-flex flex-justify-center my-4">
                        <button role="button" onclick="saveEvento()" class="button bg-green shadowed fg-white large">Guardar <span class="ml-3 mif-floppy-disk"></span></button>
                    </div>



            </div>
        </div>
    </div>






@endsection
