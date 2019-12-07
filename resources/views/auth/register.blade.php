@extends('layouts.site')

@section('title', 'Central de Erros - Registro')

@section('content')
    <div class="container">
        <div class="position-ref full-height" style="padding-top: 90px; box-sizing: border-box;">
            <h3 class="center">Registrar no Sistema</h3>
            <div class="row">
                <form method="POST" action="{{ route('register') }}" style="padding-top: 35px;">
                    {{ csrf_field() }}

                    <div class="input-field">
                        <input id="name" type="text" class="form-control" name="name" value="{{ old('name') }}" required autocomplete="name" autofocus>
                        <label for="name">Nome</label>
                    </div>

                    <div class="input-field">
                        <input id="email" type="email" class="form-control" name="email" value="{{ old('email') }}" required autocomplete="email">
                        <label for="email">E-mail</label>
                    </div>

                    <div class="input-field">
                        <input id="password" type="password" class="form-control" name="password" required autocomplete="new-password">
                        <label for="password" >Senha</label>
                    </div>

                    <div class="input-field">
                        <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required autocomplete="new-password">
                        <label for="password-confirm" >Confirme a senha</label>
                    </div>

                    <div class="form-group row mb-0">
                        <div class="col-md-6 offset-md-4">
                            <button type="submit" class="btn blue-grey lighten-1">Registrar</button>
                            <button type="reset" class="btn blue-grey darken-4">Limpar</button>
                            <button type="" class="btn blue-grey darken-3"><a style="color:#fff;"  href="{{route('home.index')}}">Voltar</a></button>
                        </div>
                    </div>
                </form>
        </div><!--row-->
    </div><!--position-ref-->
</div><!--container-->
@endsection
