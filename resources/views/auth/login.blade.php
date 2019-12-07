@extends('layouts.site')

@section('title', 'Central de Erros - Login')

@section('content')
    <div class="container">
        <div class="position-ref full-height" style="padding-top: 90px; box-sizing: border-box;">
            <h3 class="center">Entrar no Sistema</h3>
            <div class="row">
                <form action="{{ route('login.entrar') }}" method="post">
                    {{ csrf_field() }}

                    <div class="input-field">
                        <input type="text" name="email">
                        <label>E-mail</label>
                    </div>

                    <div class="input-field">
                        <input type="password" name="password">
                        <label>Senha</label>
                    </div>

                    <button class="btn blue-grey lighten-1 ">Entrar</button>
                    <button type="reset" class="btn blue-grey darken-4">Limpar</button>
                </form>
            </div>
        </div>
    </div>
@endsection