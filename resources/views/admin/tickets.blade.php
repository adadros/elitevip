@extends('layouts.admin')

@section('content')



    <div class="grid p-10 h-100">
        <div class="row p-5">
            <div class="cell-md-4">
                <div class="d-flex flex-justify-start-md flex-justify-start-sm flex-justify-center-fs">
                    <a role="button" href="{{route('admin_eventos')}}" class="button bg-black shadowed fg-lightTaupe"><span class="mif-backspace icon mr-2"></span> Regresar al listado de eventos</a>
                </div>
            </div>
            <div class="cell-md-12">
                <a role="button" class="button bg-orange shadowed fg-white p-1 mr-1">Cancelar ticket(s) <span class="mif-cross icon ml-2"></span></a>
                <a role="button" class="button bg-red shadowed fg-white p-1 mr-1">Eliminar ticket(s) <span class="mif-bin icon ml-2"></span></a>
                <a role="button" class="button bg-blue shadowed fg-white p-1">Asignar ticket(s) a usuario <span class="mif-user icon ml-2"></span></a>
            </div>
            <div class="cell-md-10">
                <table id="tickets" class="table striped table-border"
                       data-rows="10"
                       data-rows-steps="10,25,100,1000"
                       data-horizontal-scroll="true"
                       data-horizontal-scroll-stop="lg"
                       data-check="true"
                       data-check-style="2"
                       data-role="table">
                    <thead>
                    <tr>
                        <th class="sortable-column" data-sortable="true">ID</th>
                        <th class="sortable-column"  data-sortable="true">Folio</th>
                        <th class="sortable-column" data-sortable="true" data-format="money">Precio</th>
                        <th class="sortable-column" data-sortable="true">Sección</th>
                        <th class="sortable-column" data-sortable="true">Paquete</th>
                        <th class="sortable-column" data-sortable="true">Status</th>
                        <th data-format="date">Fecha</th>
                        <th>Edición</th>
                    </tr>
                    </thead>
                    <tbody>
                    @if( isset($tickets) )
                    @foreach($tickets as $ticket)
                        <tr>
                            <td>{{$ticket->id}}</td>
                            <td>{{$ticket->folio}}</td>
                            <td>${{$ticket->precio}} {{$ticket->divisa}}</td>
                            <td>{{$ticket->seccion}}</td>
                            <td>{{$ticket->paquete}}</td>
                            <td>{{$ticket->estatus}}</td>
                            <td>{{$ticket->fecha}}</td>
                            <td>
                                <div class="toolbar">
                                    <a role="button" href="{{route('admin_ticket_editar',['id'=>$ticket->id] )}}" class="tool-button primary">
                                        <span class="mif-pencil"></span>
                                    </a>
                                    <a role="button" onclick="deleteTicket(this)" data-id="{{$ticket->id}}" class="tool-button alert">
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
