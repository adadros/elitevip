@extends('layouts.profile')

@section('content')

    <div class="p-10 bd-darkTaupe">
        @if (session('status'))
            <div class="alert alert-success" role="alert">
                {{ session('status') }}
            </div>
        @endif

        @if($evento)


                <div class="mb-4" data-role="stepper"
                     data-steps="4"
                     id="stepper"
                     data-view="diamond"
                     data-cls-step="rounded bg-darkTaupe"
                     data-cls-complete="bg-lightTaupe fg-white"
                     data-cls-current="bg-darkTaupe fg-white"
                ></div>

        <div id="apartar" class="row p-5 border bd-darkTaupe pb-10 rounded">
            <div class="cell-lg-12 cell-md-12 cell-sm-12 cell-fs-12">
                <h3 class="display1 fg-lightTaupe text-bold">Aparte su boleto</h3><h6 class="display1 fg-grayWhite">{{$evento->titulo}}</h6>
            </div>


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


            <section class="container-paquete d-none cell-md-12" id="tabla_disponibilidad">
                <div class="row">
                    <div class="cell-md-12">
                        <div class="fg-white">Fecha del evento: <span id="_for_fecha"></span></div>
                        <table class="table op-darkTaupe fg-white">
                            <thead>
                                <tr class="bg-lightTaupe">
                                    <th>Seccion</th>
                                    <th>Paquete</th>
                                    <th>Costo</th>
                                    <th>Disp</th>
                                    <th>Acción</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td id="_for_seccion">Sección</td>
                                    <td id="_for_paquete">Paquete</td>
                                    <td id="_for_precio">Precio</td>
                                    <td id="_for_disponibles">0</td>
                                    <td id="accion"><a role="button" onclick="addTicket()" class="button success large cycle shadowed"><span class="mif-plus mif-2x"></span></a></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </section>
        </div>

        <div id="titulo_apartar_container">
            <div class="row d-flex flex-justify-center">
                <div style="position:relative;">
                    <div id="text_apartar" style="width:160px;" class="pos-absolute z-2 pos-top-center t-70 mb-30 text-center p-2 d-none">
                        <span class="f-size-18 p-2 fg-lightTaupe">Aparte su boleto</span>
                    </div>
                    <a onclick="slideUpApartar(this,'#apartar')" role="button" class="pos-absolute z-1 t-30 pos-top-center button cycle large bg-darkTaupe bg-lightTaupe-hover fg-white"><span class="mif-arrow-up ani-bounce"></span></a>
                </div>
            </div>

            <div class="mt-5 p-5" style="width:100%;">
                <h3 class="f-size-18 fg-lightTaupe">Boletos</h3>
                <div style="border-top:thin solid rgba(145,145,145,.2); width:100%;"> &nbsp; </div>
                <section id="paquetes_tickets" class="row">

                </section>
            </div>
            <div id="btn_invitados" class="mt-5 d-none">
                <div class="d-flex flex-justify-center">
                    <div>
                        <a role="button" onclick="usersForm()" class="button success large rounded shadow-1">Siguiente <span class="mif-chevron-thin-right ani-horizontal"></span></a>
                    </div>
                </div>
            </div>
        </div>



        <div class="d-none" id="configurar">
            <h3 class="display1 fg-lightTaupe text-bold">Configurar invitado(s)</h3>
            <div class="row m-2">
                <a role="button" onclick="back_apartar()" class="p-2 button bg-darkTaupe bg-lightTaupe-hover fg-lightTaupe fg-black-hover large rounded shadow-1"><span class="mif-backspace ani-horizontal"></span></a>
            </div>
            <div class="row p-5 mt-5">
                <div class="cell-lg-8 op-darkTaupe-hi border bd-lightTaupe fg-white">
                    <label><h6>Invitados</h6></label>
                    <p class="p-4">
                        <b>Nota:</b> En caso de que el boleto sea para más de una persona se tiene que completar los campos con el nombre completo del invitado y dar clic en siguiente.
                    </p>
                </div>
            </div>
            <div class="row ">

                <div id="user_container" class="cell-lg-8 cell-md-10 cell-sm-10 cell-fs-12">

                </div>


            </div>
            <div class="d-flex flex-justify-end">
                <div>
                    <a role="button" onclick="pasoPago()" class="button success large rounded shadow-1">Siguiente <span class="mif-chevron-thin-right"></span></a>
                </div>
            </div>

        </div>

        <div id="detallepago" class="d-none">
            <div id="ticket_detalle"></div>

            <h3 class="display1 fg-lightTaupe text-bold">Detalle del pedido</h3>
            <div class="row">

                <div class="cell-md-8 fg-black" style="background: rgba(0,0,0,0);">

                        <div class="card bg-lightGray fg-black">

                            <div class="card-body p-4 f-size-16">
                                <div class="row m-1">
                                    <div class="cell-md-12">
                                        <div style="border-top:1px solid rgba(145,145,145,.4);" class="p-4 bg-black fg-white"> Orden de compra </div>
                                        <div class="display-tr p-4 bg-grayWhite">
                                            <h3>{{$evento->titulo}}</h3>
                                        </div>
                                        <table id="monto" class="table">
                                            <thead>
                                            <tr><th>Tickets</th> <th>Costo</th></tr>
                                            </thead>
                                            <tbody>

                                            </tbody>
                                        </table>
                                        <div class="d-flex flex-justify-center">
                                            <div class="mt-5">
                                                <a role="button" onclick="irAPago()" class="button success large rounded shadowed">Ir a pagar <span class="mif-chevron-thin-right"></span></a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                </div>
            </div>
        </div>

        <div id="pagar" class="d-none">
            <!--pagar-->
            <h3 class="display1 fg-lightTaupe text-bold">Pagar boleto(s)</h3>
            <div class="row">

                <div class="cell-md-8 fg-black" style="background: rgba(0,0,0,0);">
                    <form id="card-form" >


                        <input type="hidden" name="conektaTokenId" id="conektaTokenId" value="">
                        <!--monto pago-->
                        <input type="hidden" name="monto_pago" id="monto_pago" value="">

                        <div class="card bg-lightGray fg-black">

                            <div class="card-body p-4 f-size-16">
                                <div class="row">

                                    <table class="table">
                                        <tbody>
                                        <tr><td align="left"><b class="f-size-18">Total a pagar</b></td><td id="for_monto" class="f-size-18" align="right"></td></tr>
                                        </tbody>
                                    </table>
                                </div>
                                <div class="row mx-0 mb-4">
                                    <div style="border-top:1px solid rgba(145,145,145,.4);" class="cell-md-12 p-4 bg-black fg-white"> Datos del tarjetahabiente </div>
                                </div>
                                <div class="row m-1">

                                    <div class="cell-md-6">
                                        <label>
                                            Nombre
                                        </label>
                                        <input value="{{ session('profile')['nombre'].' '.session('profile')['apellido'] }}" data-conekta="card[name]" name="name" id="name"  type="text" data-role="input" >
                                    </div>
                                    <div class="cell-md-6">
                                        <label>Número de tarjeta</label>
                                        <input value="" name="card" id="card" data-conekta="card[number]" onchange="getBrandCard()" type="text" maxlength="16" data-role="input" >

                                    </div>
                                    <div class="cell-md-12 my-0 py-0">
                                        <div class="d-flex flex-justify-end"><span id="card_brand" class='ml-2 mif-credit-card mif-4x'></span></div>
                                    </div>
                                </div>

                                <div class="row mx-1 my-3">
                                    <div class="cell-md-6">
                                        <label>
                                            CVC
                                        </label>
                                        <input value="" data-conekta="card[cvc]" data-size="120" type="text" maxlength="4" data-role="input" >
                                    </div>
                                    <div class="cell-md-6">
                                        <label>
                                            Fecha de expiración (MM/AA)
                                        </label>
                                        <div class="d-flex flex-row">
                                            <div><input data-role="input" data-size="100" value="" data-conekta="card[exp_month]"   type="text" maxlength="2" ></div>
                                            <div class="ml-4"><input data-role="input" data-size="100" value="" data-conekta="card[exp_year]" type="text" maxlength="2" ></div>
                                        </div>
                                    </div>
                                </div>
                                <div class="d-flex flex-justify-center">
                                    <div class="mt-5">
                                        <a role="button" onclick="procesaPago()" class="button success large rounded shadowed">Pagar <span class="ml-5 mif-credit-card"></span></a>
                                    </div>
                                </div>




                            </div>
                        </div>
                    </form>

                </div>
            </div>
            <!--pagar-->



        </div>
        <input type="hidden" id="idevento" value="{{$evento->id}}">
        <input type="hidden" id="evento_titulo" value="{{$evento->titulo}}">
        <input type="hidden" value="{{ Config::get('constants.CONEKTA_TOKEN')  }}" id="token_conekta">

        @endif


    </div>







@endsection
