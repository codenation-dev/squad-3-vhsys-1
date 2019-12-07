@extends('layouts.site')

@section('title', 'Registrar Log de Erros')

@section('content')

<div class="container">
    <h3 class="center mt-5">Registrar Log</h3>
    <div class="row" style="min-height: 406px;">
        <form class="col s12" action="{{ route('erros.salvar') }}" method="post">
            {{ csrf_field() }}
            @include('erros._form')

            <div class="row mt-3">
                <button type="submit" class="btn blue-grey darken-1">Salvar</button>
                <button type="reset" class="btn blue-grey darken-3">Limpar</button>
                <button type="" class="btn blue-grey darken-4"><a style="color:#fff;"  href="{{route('erros')}}">Voltar</a></button>
            </div>
    </div>
</div>

@endsection




