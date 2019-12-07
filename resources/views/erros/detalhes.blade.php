@extends('layouts.site')

@section('title', 'Detalhes do Log')

@section('content')

<div class="container">
    <h4 class="center  mt-5">Detalhes do Erro - {{  $registros->titulo }}</h4>
    <div class="row col">
        <div class="card darken-1">
            <div class="card-content">
                <span class="card-title">Título - {{  $registros->titulo }}</span>
                <div class="desc">
                    <h6><b>Descrição:</b></h6>
                    <p class="pb-1">{{  $registros->descricao }}</p>
                    <p class="pb-1"> <span>Eventos:</span> {{  $registros->eventos }}</p>
                    <p class="pb-1">Nível: <span class=" span-erro {{strtolower($registros->nivel)}}">{{$registros->nivel}}</span> </p>
                    <p class="pb-1">Status: <span class="span-status {{strtolower($registros->status)}}">{{ mb_convert_case($registros->status , MB_CASE_TITLE) }}</span></p>
                    <p class="pb-1">Data: <span>{{  $registros->created_at }}</span></p>
                    <p class="pb-1">Usuário: <span>{{ Auth::user()->name }}</span></p>
                </div>
            </div>
            <div class="card-action center">
                <a class="btn blue-grey darken-4" style="color:#fff; margin: 0 !important"  href="{{route('erros')}}">Voltar</a>
            </div>
        </div>
    </div>
</div>
@endsection