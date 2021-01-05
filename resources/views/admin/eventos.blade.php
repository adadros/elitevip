@extends('layouts.admin')

@section('content')

    <div class="grid p-10 h-100">
        <div class="row p-5">
            <div class="cell-md-4">
                <a role="button" href="{{route('admin_evento_nuevo')}}" class="button bg-black shadowed fg-lightTaupe bg-darkTaupe-hover"><span class="mif-plus icon mr-2"></span> Agregar evento</a>
            </div>
            <div class="cell-md-10">
                <table id="eventos" class="table striped table-border" data-role="table">
                    <thead>
                    <tr>
                        <th data-sortable="true">Folio</th>
                        <th data-sortable="true">Nombre</th>
                        <th>Boletos</th>
                        <th>Edición</th>
                    </tr>
                    </thead>
                    <tbody>
                    @if( isset($eventos) )
                        @foreach($eventos as $evento)
                            <tr>
                                <td>{{$evento->id}}</td>
                                <td>{{$evento->titulo}}</td>
                                <td><a role="button" href="{{route('admin_tickets',['id'=>$evento->id])}}" class="button bg-darkTaupe fg-white small">Tickets <span class="mif-stack3"></span></a></td>
                                <td>
                                    <div class="toolbar">
                                        <a role="button" href="{{route('admin_evento_editar',['id'=>$evento->id] )}}" class="tool-button primary">
                                            <span class="mif-pencil"></span>
                                        </a>
                                        <a role="button" data-name="{{$evento->titulo}}" onclick="deleteEvento(this)" data-id="{{$evento->id}}" class="tool-button alert">
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
