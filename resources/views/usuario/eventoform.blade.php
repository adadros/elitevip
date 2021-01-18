@extends('layouts.profile')

@section('content')

    <div class="p-10 bd-darkTaupe">
        @if (session('status'))
            <div class="alert alert-success" role="alert">
                {{ session('status') }}
            </div>
        @endif

        @if($evento)
        <h2>Aparte su boleto</h2>

        <div class="row">

            <div id="fechas_select" class="cell-lg-4">
                        <label class="fg-lightTaupe m-1">Selecciona la fecha deseada</label>
                        @if(isset($fechas))
                            <select class="bg-black fg-white" data-evento="{{$evento->id}}"
                                            id="fechas" name="fechas" data-role="select"
                                            data-filter-placeholder="Buscar"
                                            data-cls-option="bg-black fg-lightTaupe bg-darkTaupe-hover fg-white-hover"
                                            data-cls-selected-item="bg-black fg-lightTaupe fg-taupe-hover border bd-taupe"
                                            data-cls-selected-item-remover="bg-black fg-taupe"
                                            data-cls-drop-list = "bg-black fg-taupe",
                                            data-on-change = "eventoGetSections(this)"

                                    >
                                @foreach($fechas as $fecha)
                                    <option value="{{$fecha['fecha']}}">{{$fecha['label']}}</option>
                                @endforeach
                            </select>
                        @endif
            </div>

            <div id="secciones" class="d-none cell-lg-4">
                <label class="fg-lightTaupe m-1">Selecciona la sección</label>
            </div>
            <div id="paquetes" class="d-none cell-lg-4">
                <label class="fg-lightTaupe m-1">Selecciona el paquete</label>
                <div class="container-paquete"></div>
            </div>


            <div id="available-container" class="d-none mt-5 available-tickets cell-md-12 cell-sm-12 cell-fs-12 cell-lg-12 text-center">
                <label class="fg-lightTaupe m-1 d-inline">Checar disponibilidad </label>
                <a role="button" class="d-inline ml-1 button bg-darkTaupe bg-taupe-hover fg-white large rounded smit-available" onclick="getAvailable(this,{{$evento->id}})"> <span class="mif-calendar"></span> </a>
                <div id="disponible" class="d-inline d-none text-center ml-2">

                </div>
            </div>

            <div id="ticket-fake" class="cell-lg-6 d-none">
                <div class="card op-white-hi border-dashed bd-lightTaupe">
                    <div class="card-header bg-darkTaupe fg-white p-0">
                        <div class="p-2">{{$evento->titulo}} </div>
                        <div class="row list-ticket bg-black fg-lightTaupe pos-relative mx-0" style="background-image:url({{asset('images/cintilla.gif')}}); height:30px;">

                        </div>
                    </div>
                    <div class="card-content content-ticket px-1" style="background-image:url({{asset('images/bgbodycard200.gif')}})">

                        <div class="row fg-black p-2">

                            <div class="cell-md-6 col-sm-6 col-fs-6 mt-1">
                                Fecha: <span id="for_date" class="p-1 px-2 op-white-low"> 12/12/23 </span>
                            </div>
                            <div class="cell-md-6 col-sm-6 col-fs-6 mt-1 text-right-md">
                                Seccion: <span id="for_seccion" class="p-1 px-2 op-white-low"> nivel 1 </span>
                            </div>
                            <div class="cell-md-6 col-sm-6 col-fs-6 mt-1">
                                Paquete: <span id="for_paquete" class="p-1 px-2 op-white-low"> paquete </span>
                            </div>
                            <div class="cell-md-6 col-sm-6 col-fs-6 mt-1 text-right-md">
                                Precio: <span id="for_price" class="p-1 px-2 op-white-low"> $100 dls</span>
                            </div>

                            <div class="cell-md-6 col-sm-6 col-fs-6 mt-1">
                                Aplica para: <span id="for_persona" class="p-1 px-2 op-white-low"> 1 persona</span>
                            </div>

                        </div>
                    </div>
                    <div class="card-footer bg-black fg-lightTaupe">
                        <div class="footer-ticket form-group">
                            <div class="row w-100-lg">
                                <div id="ctn-cantidad" class="cell-md-8 text-center">
                                    <label>¿Cuantos tickets quieres?</label>
                                    <input id="cantidad" type="number" data-max-value="100" data-step="1" data-min-value="1" data-role="spinner" value="1">
                                </div>
                                <div class="cell-md-4 text-right-lg text-right-md text-right-sm text-center-fs va-middle">
                                    <a role="button" onclick="pagarForm()" class="button success large rounded shadow-1">Comprar <span class="ml-2 mif-credit-card"></span></a>
                                </div>
                            </div>

                        </div>

                    </div>
                </div>
            </div>




        </div>

        @endif


    </div>



@endsection
