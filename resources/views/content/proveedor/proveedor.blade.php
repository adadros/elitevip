
@extends('layouts.app')

@section('content')

    <div class="container mt-15" id="registro-form"  >
        <section>
            <h3 class="display1 fg-lightTaupe text-bold">Proveedores</h3>

            <div class="descripcion fg-lightTaupe op-darkTaupe-hi py-3 px-3 mb-2">
                <h4>Escríbenos a través de este formulario y nosotros te contactaremos.</h4>
            </div>

            <form method="post" action="{{route('proveedores_send')}}">
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
                            <div class="form-group">
                                <label class="left">Productos o servicios que ofreces</label>
                                <textarea id="servicios" name="servicios" type="text" class="metro-input">{{old('servicios')}}</textarea>
                                <small class="error">{{$errors->first('servicios')}}</small>
                            </div>

                            <div class="form-group">
                                <label class="left">Trabajos previos</label>
                                <textarea id="trabajos" name="trabajos" type="text" class="metro-input">{{old('trabajos')}}</textarea>
                                <small class="error">{{$errors->first('trabajos')}}</small>
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