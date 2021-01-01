
@extends('layouts.app')

@section('content')

    <div class="container mt-15" id="login-form" >
        <section>
            <form method="POST" action="{{ route('login') }}" >
                {{@csrf_field()}}
                <div class="grid">
                    <div class="row">
                        <div id="ct-login" class="mt-20 cell-md-4 mx-auto cell-sm-8 fg-lightTaupe p-10 border bd-darkTaupe">
                            <h3 class="display1 fg-lightTaupe text-bold">Inicia sesión</h3>
                            <div class="form-group">
                                <label class="left">Usuario</label>
                                <input id="email" name="email" type="text" data-role="input" class="@error('email') is-invalid @enderror" value="{{ old('email') }}" required autocomplete="email" autofocus >
                                @error('email')
                                    <small class="mt-5 error">{{ $message }}</small>
                                @enderror

                            </div>
                            <div class="form-group">
                                <label class="left">Password</label>
                                <input id="password" name="password" type="password" data-role="input" class="@error('password') is-invalid @enderror" required autocomplete="current-password" >
                                @error('password')
                                <small class="mt-5 error">{{ $message }}</small>
                                @enderror
                            </div>

                            <div class="d-flex flex-justify-center">
                                <button class="mt-15 pl-10 pr-10 button shadowed bg-taupe fg-white large rounded bg-lightTaupe-hover" onclick="submit()">Inicia sesión</button>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </section>
    </div>


@endsection