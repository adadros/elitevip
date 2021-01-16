
@extends('layouts.app')

@section('content')

    <div class="container mt-15" id="registro-form"  >
        <section>
            <h3 class="display1 fg-lightTaupe text-bold">Contacto</h3>

            <div class="descripcion fg-lightTaupe op-darkTaupe-hi py-3 px-3 mb-2">
                <div><span class="mif-location-city mr-2"></span>  Calle 17 188 por 26 esquina, Miraflores, C.P. 97179 Mérida, Yuc. </div>
                <div><span class="mif-phone mr-2"></span> (999)7576571. </div>
                <div><i class="fas fa-clock mr-2"></i> 9:00 a.m. a 4:00 p.m.</div>
            </div>

            <form method="post" action="{{route('contacto_send')}}">
                {{@csrf_field()}}
                <div class="grid">
                    <div class="row">
                        <div class="cell-md-5 cell-sm-full fg-lightTaupe">
                            <div class="form-group">
                                <label class="left">Nombre</label>
                                <input id="nombre" name="nombre" type="text" value="{{old('nombre')}}"  class="metro-input">
                                <small class="error">{{$errors->first('nombre')}}</small>
                            </div>
                            <div class="form-group">
                                <label class="left">Correo electrónico</label>
                                <input id="correo" name="correo" type="email" value="{{old('correo')}}" class="metro-input" >
                                <small class="error">{{$errors->first('correo')}}</small>
                            </div>
                            <div class="form-group">
                                <label class="left">Teléfono</label>
                                <input id="telefono" name="telefono" type="text" data-role="input-mask" class="metro-input" data-mask="+(**) **** ******" data-mask-editable-start="0" data-mask-placeholder="*" value="{{old('telefono')}}">
                                <small class="error">{{$errors->first('telefono')}}</small>
                            </div>
                            <div class="form-group">
                                <label class="left">Ocupación</label>
                                <input id="ocupacion" name="ocupacion" type="text" class="metro-input" value="{{old('ocupacion')}}">
                                <small class="error">{{$errors->first('ocupacion')}}</small>
                            </div>

                            <!---Paises-->
                            <div class="form-group">
                                <label class="left">¿Cuáles son tus paises favoritos?</label>
                                <ul class="ismultiple" data-id="paises">

                                    @foreach( old('paises', ['value']) as $pais)
                                        <li>{{$pais}}</li>
                                    @endforeach

                                </ul>
                                <select class="bg-black" id="paises" name="paises[]" data-role="select"
                                        data-filter-placeholder="Buscar"
                                        data-cls-option="bg-black fg-lightTaupe bg-darkTaupe-hover fg-white-hover"
                                        data-cls-selected-item="bg-black fg-lightTaupe fg-taupe-hover border bd-taupe"
                                        data-cls-selected-item-remover="bg-black fg-taupe"
                                        data-cls-drop-list = "bg-black fg-taupe"
                                        multiple>
                                    @foreach($paises as $pais)
                                        <option value="{{$pais->id}}">{{$pais->nombre}}</option>
                                    @endforeach
                                </select>
                                <small class="error">{{$errors->first('paises')}}</small>

                            </div>

                            <!---Paises-->
                            <div class="form-group">
                                <label class="left">¿Cuáles son tus hoteles favoritos?</label>
                                <textarea id="hoteles" name="hoteles" type="text" class="metro-input">{{old('hoteles')}}</textarea>
                                <small class="error">{{$errors->first('hoteles')}}</small>
                            </div>

                        </div>


                        <div class="cell-md-5 offset-md-2 cell-sm-full fg-lightTaupe">


                                <div class="form-group">
                                    <label class="left">¿Cual es tu dj favorito?</label>
                                    <ul class="ismultiple" data-id="djs">
                                        @foreach(old('djs', ['value']) as $dj)
                                            <li>{{$dj}}</li>
                                        @endforeach
                                    </ul>
                                    <select class="bg-black"
                                            id="djs" name="djs[]" data-role="select"
                                            data-filter-placeholder="Buscar"
                                            data-cls-option="bg-black fg-lightTaupe bg-darkTaupe-hover fg-white-hover"
                                            data-cls-selected-item="bg-black fg-lightTaupe fg-taupe-hover border bd-taupe"
                                            data-cls-selected-item-remover="bg-black fg-taupe"
                                            data-cls-drop-list = "bg-black fg-taupe"
                                            multiple>
                                        @foreach($djs as $dj)
                                            <option value="{{$dj->id}}">{{$dj->nombre}}</option>
                                        @endforeach
                                    </select>
                                    <small class="error">{{$errors->first('djs')}}</small>
                                </div>


                                <div class="form-group">
                                    <label class="left">¿Qué tipo de música te agrada más?</label>
                                    <input id="tipomusica" name="tipomusica" type="text" value="{{old('tipomusica')}}" class="metro-input">
                                    <small class="error">{{$errors->first('tipomusica')}}</small>
                                </div>
                                <div class="form-group">
                                    <label class="left">¿Cúales son tus hobbies favoritos?</label>
                                    <textarea id="hobbie" name="hobbie" type="text" class="metro-input">{{old('hobbie')}}</textarea>
                                    <small class="error">{{$errors->first('hobbie')}}</small>
                                </div>
                                <div class="form-group">
                                    <label class="left">¿Cómo podemos encontrarte en tus redes sociales?</label>
                                    <input id="redes" name="redes" type="text" value="{{old('redes')}}" class="metro-input">
                                    <small class="error">{{$errors->first('redes')}}</small>
                                </div>
                        </div>
                    </div>
                    <div class="d-flex flex-justify-center">
                        <button class="mt-15 pl-10 pr-10 button shadowed bg-taupe fg-white large rounded bg-lightTaupe-hover" onclick="submit()">Enviar</button>
                    </div>
                </div>
            </form>
        </section>
    </div>




@endsection