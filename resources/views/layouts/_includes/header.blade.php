<!DOCTYPE html>
<html lang="pt-br">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/css/materialize.min.css">
  <script src="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/js/materialize.min.js"></script>
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title>@yield('title')</title>
  <style>
    html, body {
      background-color: #fff;
      color: #636b6f;
      font-family: 'Spinnaker', sans-serif;
      font-weight: 200;
      height: 100vh;
      margin: 0;
    }

    .full-height {
      min-height: 74.5vh;
    }

    .flex-center {
      align-items: center;
      display: flex;
      justify-content: center;
    }

    .position-ref {
      position: relative;
    }

    .content {
      text-align: center;
    }

    .title {
      font-size: 54px;
    }

    .links > a {
      color: #636b6f;
      padding: 0 25px;
      font-size: 16px;
      font-weight: 600;
      letter-spacing: .1rem;
      text-decoration: none;
      text-transform: uppercase;
    }

    a.disabled {
      pointer-events: none;
      cursor: default;
    }

    .mt-3 {
      margin-top: 2rem;
    }

    .mt-5 {
      margin-top: 3rem;
    }

    .pb-1 {
      padding-bottom: 1rem;
    }

    .span-erro {
      color: #fff;
      padding: 6px;
      border-radius: 2px;
    }

    .error {
      background: #b71c1c;
    }

    .warning {
      background: #f4511e;
    }

    .debug {
      background: #fdd835;
    }

    .ativo {
      color: #b71c1c;
    }

    .concluido {
      color: #009688;
    }

    .links > a:hover {
      color: #000;
    }

    .input-field span {
      color: #9e9e9e !important;
    }

    .bolder {
      font-weight: bold;
    }
    @media screen and (max-width: 992px)
    {
      .log-origin, .log-title
      {
        display: none;
      }
    }
    @media screen and (max-width: 960px)
    {
      nav .brand-logo
      {
        font-size: 4vw !important;
      }
      .content.home a, .content.home .title
      {
        font-size: 3vw !important;
      }
      .content.home .title,
      .content.home h4
      {
        font-size: 6vw !important;
      }
      .detail-title
      {
        font-size: 4.5vw !important;
      }
      .welcome
      {
        font-size: 3.6vw !important;
      }
      .footer-text
      {
        font-size: 3vw !important;
      }
    }

  </style>
</head>

<body>
<header>
  <nav>
    <div class="nav-wrapper grey darken-2">
      <div class="container">
        <a href="{{route('home.index')}}" class="brand-logo"  style="font-size: 2.5vw">Squad 3</a>
        <a href="#" data-target="mobile" class="sidenav-trigger"><i class="material-icons">menu</i></a>
        <ul class="right hide-on-med-and-down">
          <li><a href="{{route('home.index')}}">Home</a></li>
          @if(Auth::guest())
            <li><a href="{{route('login')}}">Login</a></li>
          @else
            <li><a href="{{route('erros')}}">Erros</a></li>
            <li><a href="{{ route('login.sair') }}">Sair</a></li>
            <li><a href="#" class="disabled">{{ Auth::user()->name }}</a></li>
          @endif

        </ul>

        <ul class="sidenav hide-on-large-only" id="mobile">
          <li><a href="{{route('home.index')}}">Home</a></li>
          @if(Auth::guest())
            <li><a href="{{route('login')}}">Login</a></li>
          @else
            <li><a href="{{route('erros')}}">Erros</a></li>
            <li><a href="#">Bem vindo {{ Auth::user()->name }}</a></li>
            <li><a href="{{ route('login.sair') }}">Sair</a></li>
          @endif
        </ul>
      </div>
    </div>
  </nav>
</header>