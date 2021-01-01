@extends('layouts.admin')

@section('content')

    <div class="grid p-10 h-100">
        <div class="row p-5">
            <div class="cell-md-4">
                <a role="button" href="{{route('admin_evento_nuevo')}}" class="button bg-black shadowed fg-lightTaupe bg-darkTaupe-hover"><span class="mif-plus icon mr-2"></span> Agregar evento</a>
            </div>
            <div class="cell-md-10">
                <table class="table" data-role="table">
                    <thead>
                    <tr>
                        <th data-sortable="true">Folio</th>
                        <th data-sortable="true">Name</th>
                        <th data-sortable="true">Fecha</th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr>

                    </tr>

                    </tbody>
                </table>
            </div>
        </div>
    </div>

@endsection
