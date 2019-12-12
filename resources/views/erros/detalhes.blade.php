@extends('layouts.site')

@section('title', 'Detalhes do Log - ' . $registros->titulo)

@section('content')

  <?php
    if($registros->ambiente === 1) {
      $registros->ambiente = 'Produção';
    } elseif ($registros->ambiente === 2) {
      $registros->ambiente = 'Homologação';
    } else {
      $registros->ambiente = 'Desenvolvimento';
    }
  ?>

  <div class="container">
    <h4 class="center mt-5  detail-title">Detalhes do Log - {{  $registros->titulo }}</h4>
    <h6 class="center pb-1"> <span>Ocorrido no </span> {{  $registros->origem }} em {{  $registros->created_at }}</h6>

    <div class="row col">
      <div class="card darken-1">
        <div class="card-content">
          <h5><b>Título</b></h5>
          <h6 class="pb-1">{{  $registros->titulo }}</h6>
          <div class="desc">
            <h5><b>Detalhes</b></h5>
            <p class="pb-1">{{  $registros->descricao }}</p>
            <p class="pb-1"> <span class="bolder">Eventos:</span> {{  $registros->eventos }}</p>
            <p class="pb-1"> <span class="bolder">Origem:</span> {{  $registros->origem }}</p>
            <p class="pb-1"> <span class="bolder">Ambiente:</span> {{  ($registros->ambiente) }}</p>
            <p class="pb-1"><span class="bolder">Nível:</span>  <span class=" span-erro {{strtolower($registros->nivel)}}">{{$registros->nivel}}</span> </p>
            <p class="pb-1"><span class="bolder">Status:</span>  <span class="span-status {{strtolower($registros->status)}}">{{ mb_convert_case($registros->status , MB_CASE_TITLE) }}</span></p>
            <p class="pb-1"><span class="bolder">Data:</span>  <span>{{  $registros->created_at }}</span></p>
            <p class="pb-1"><span class="bolder">Usuário:</span>  <span>{{ Auth::user()->name }}</span></p>
          </div>
        </div>
        <div class="card-action center">
          <a class="btn blue-grey darken-4" style="color:#fff; margin: 0 !important"  href="{{route('erros')}}">Voltar</a>
        </div>
      </div>
    </div>
  </div>
@endsection