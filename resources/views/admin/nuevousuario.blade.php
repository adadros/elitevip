@extends('layouts.admin')

@section('content')

    <div class="grid p-10">
        <div class="row p-5">
            <div class="cell-md-4 cell-sm-4 cell-fs-12">
                <div class="d-flex flex-justify-start-md flex-justify-start-sm flex-justify-center-fs">
                    <a role="button" href="{{route('admin_usuarios')}}" class="button bg-black shadowed fg-lightTaupe"><span class="mif-backspace icon mr-2"></span> Regresar al listado</a>
                </div>
            </div>

            <div class="cell-md-12">
                @if($editable)
                    <h2>Editar usuario</h2>
                @else
                    <h2>Nuevo usuario</h2>
                @endif


                <div class="row">
                    <div class="cell-md-10 cell-sm-10 cell-fs-12">
                        <div class="form-group">
                            <label>Nombre</label>
                            <input data-size="300" id="nombre" name="nombre" type="text" data-role="input" value="">
                        </div>
                        <div class="form-group">
                            <label>Apellido</label>
                            <input data-size="300" id="apellido" name="apellido" type="text" data-role="input" value="">
                        </div>

                        <div class="form-group">
                            <label>Correo electrónico</label>
                            <input data-size="300"  id="correo" name="correo" type="email" data-role="input" value="">
                        </div>

                        <div class="form-group">
                            <div><input id="aprobar" type="checkbox" data-role="switch" data-off="No" data-on="Si" data-caption="<label>Aprobar y activar</label>" data-caption-position="left"></div>
                        </div>
                        <div class="form-group">
                            <label>Rol del usuario</label>
                            <div class="row">
                                <div class="cell-lg-6 cell-md-6 cell-fs-10">
                                    <select id="role" data-role="select">
                                        <option selected="selected" value="2" data-template="<span class='mif-user icon'></span> $1">Usuario</option>
                                        <option value="1" data-template="<span class='mif-verified icon'></span> $1">Admin</option>
                                    </select>
                                </div>
                            </div>
                        </div>


                    </div>

                </div>
                <div class="border border-bottom-none border-left-none border-right-none bd-lightTaupe py-5 d-flex flex-justify-center my-4">
                    @if($editable)
                        <button role="button" onclick="updateUsuario({{$id}}) " class="button bg-green shadowed fg-white large">Actualizar <span class="ml-3 mif-floppy-disk"></span></button>
                    @else
                        <button role="button" onclick="saveUsuario()" class="button bg-green shadowed fg-white large">Guardar <span class="ml-3 mif-floppy-disk"></span></button>
                    @endif
                </div>

            </div>
        </div>
    </div>






@endsection
