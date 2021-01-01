@extends('layouts.admin')

@section('content')



    <div class="grid p-10 h-100">
        <div class="row p-5">
            <div class="cell-md-4">
                <a role="button" href="{{route('admin_paquete_nuevo')}}" class="button bg-black shadowed fg-lightTaupe bg-darkTaupe-hover"><span class="mif-plus icon mr-2"></span> Agregar paquete</a>
            </div>
            <div class="cell-md-10">
                <table id="paquetes" class="table striped table-border"
                       data-rows="10"
                       data-rows-steps="10,25,100,1000"
                       data-horizontal-scroll="true"
                       data-horizontal-scroll-stop="lg"
                       data-role="table">
                    <thead>
                    <tr>
                        <th class="sortable-column" data-sortable="true">ID</th>
                        <th class="sortable-column"  data-sortable="true">Nombre</th>
                        <th class="sortable-column" data-sortable="true" data-format="money">Precio</th>
                        <th class="sortable-column" data-sortable="true">Cant. Personas</th>
                        <th>Edición</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($paquetes as $paquete)
                        <tr>
                            <td>{{$paquete->id}}</td>
                            <td>{{$paquete->nombre}}</td>
                            <td>${{$paquete->precio}} dls.</td>
                            <td>{{$paquete->personas}}</td>
                            <td>
                                <div class="toolbar">
                                    <a role="button" href="{{route('admin_paquete_editar',['id'=>$paquete->id] )}}" class="tool-button primary">
                                        <span class="mif-pencil"></span>
                                    </a>
                                    <a role="button" onclick="deletePaquete(this)" data-id="{{$paquete->id}}" class="tool-button alert">
                                        <span class="mif-bin"></span>
                                    </a>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

@endsection
