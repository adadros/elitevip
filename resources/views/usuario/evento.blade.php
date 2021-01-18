@extends('layouts.profile')

@section('content')

    <div class="h-100 p-10 bd-darkTaupe">
        @if (session('status'))
            <div class="alert alert-success" role="alert">
                {{ session('status') }}
            </div>
        @endif

        @if($evento)
            <div class="row op-darkTaupe-hi w-100 p-2">
                <div class="cell-md-8">
                    @if(isset($fechas))
                        @foreach($fechas as $fecha)
                            <div><span class="mif-calendar mr-1"></span> {{$fecha}}</div>
                        @endforeach
                    @endif
                </div>
                <div class="cell-md-4 text-right">
                    <a role="button" href="{{route('evento_apartar',['id'=>$evento->id])}}" class="button success large rounded">Comprar boleto <span class="mif-tags"></span></a>
                </div>
            </div>
            <div class="row">
                <div class="cell-lg-8">
                     <h2>{{$evento->titulo}}</h2>
                    <div class="evento-descripcion cell-lg-10">
                        <?php print $evento->descripcion; ?>
                    </div>
                </div>
            </div>
        @endif


    </div>



@endsection
