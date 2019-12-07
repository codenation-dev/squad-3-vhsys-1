@extends('layouts.site')

@section('title', 'Editar Log')

@section('content')

<div class="container">
    <h3 class="center  mt-5">Editar Log de Erro</h3>
    <div class="row" style="min-height: 406px;">
        <form  class="col s12" action="{{ route('erros.atualizar', $registro->id) }}" method="post">
            {{ csrf_field() }}
            <input type="hidden" name="_method" value="put" >
            @include('erros._form')

            <div class="row" style="padding-top: 1px;">
                <button class="btn blue-grey darken-1">Atualizar</button>
                <button type="" class="btn blue-grey darken-4"><a style="color:#fff;"  href="{{route('erros')}}">Voltar</a></button>
            </div>
        </form>

    </div>
</div>
@endsection