@extends('layouts.admin')

@section('content')

    <div class="grid p-10 h-100">
        <div class="row p-5">
            <div class="cell-md-4">
                <a role="button" href="{{route('admin_seccion_nueva')}}" class="button bg-black shadowed fg-lightTaupe bg-darkTaupe-hover"><span class="mif-plus icon mr-2"></span> Agregar sección</a>
            </div>
            <div class="cell-md-10">
                <table id="secciones" class="table striped table-border"
                       data-rows="10"
                       data-rows-steps="10,25,100,1000"
                       data-horizontal-scroll="true"
                       data-horizontal-scroll-stop="lg"
                       data-role="table">
                    <thead>
                    <tr>
                        <th class="sortable-column" data-sortable="true">ID</th>
                        <th class="sortable-column"  data-sortable="true">Tipo</th>
                        <th class="sortable-column" data-sortable="true" >Nombre</th>
                        <th>Edición</th>
                    </tr>
                    </thead>
                    <tbody>
                    @if(isset($secciones))
                        @foreach($secciones as $seccion)
                        <tr>
                            <td>{{$seccion->id}}</td>
                            <td>{{$seccion->tipo}}</td>
                            <td>{{$seccion->nombre}}</td>
                            <td>
                                <div class="toolbar">
                                    <a role="button" href="{{route('admin_seccion_editar',['id'=>$seccion->id] )}}" class="tool-button primary">
                                        <span class="mif-pencil"></span>
                                    </a>
                                    <a role="button" onclick="deleteSeccion(this)" data-id="{{$seccion->id}}" class="tool-button alert">
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
