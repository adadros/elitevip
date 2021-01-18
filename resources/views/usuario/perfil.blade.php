@extends('layouts.profile')

@section('content')

    <div class="h-100 p-10 bd-darkTaupe">
        @if (session('status'))
            <div class="alert alert-success" role="alert">
                {{ session('status') }}
            </div>
        @endif


        @include('includes.ultimos_eventos')


    </div>



@endsection
