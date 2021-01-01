@extends('layouts.admin')

@section('content')

    <div class="grid p-10 h-100">
        <div class="row p-5">
            <div class="cell-md-4">
                <a role="button" href="{{route('admin_usuario_nuevo')}}" class="button bg-black shadowed fg-lightTaupe bg-darkTaupe-hover"><span class="mif-plus icon mr-2"></span> Agregar usuario</a>
            </div>
            <div class="cell-md-10">
                <table id="usuarios" class="table striped table-border"
                       data-rows="10"
                       data-rows-steps="10,25,100,1000"
                       data-role="table"
                       data-horizontal-scroll="true"

                >
                    <thead>
                    <tr>
                        <th class="sortable-column" data-sortable="true">ID</th>
                        <th class="sortable-column"  data-sortable="true">Nombre</th>
                        <th >Email</th>
                        <th>Aprobado</th>
                        <th>Rol</th>
                        <th>Edición</th>
                    </tr>
                    </thead>
                    <tbody>


                    @if( isset($perfiles) )
                    @foreach($perfiles as $perfil)
                        <tr>
                            <td>{{$perfil->id}}</td>
                            <td>{{$perfil->nombre}} {{$perfil->apellido}}</td>
                            <td>{{$perfil->email}}</td>
                            <td>@if($perfil->activo)
                                   <span class="p-1">Aprobado <a role="button" class="button bg-taupe fg-white"><i class="mif-done"></i></a></span>
                                @else
                                   <span class="p-1"><span class="stitle">Pendiente</span> <a role="button" data-email="{{$perfil->email}}" data-nombre="{{$perfil->nombre}} {{$perfil->apellido}}" data-id="{{$perfil->id}}"  onclick="aprobarUsuario(this)" class="button bg-primary bg-green-hover "><i class="mif-done"></i></a></span>
                                @endif
                            </td>
                            <td>{{$perfil->descripcion}}</td>
                            <td>
                                <div class="toolbar">
                                    <a role="button" href="{{route('admin_usuario_editar',['id'=>$perfil->id] )}}" class="tool-button primary">
                                        <span class="mif-pencil"></span>
                                    </a>
                                    <a role="button" onclick="deleteUsuario(this)" data-id="{{$perfil->id}}" class="tool-button alert">
                                        <span class="mif-bin"></span>
                                    </a>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                    @endif
                    </tbody>
                </table>
            </div>
        </div>
    </div>

@endsection
