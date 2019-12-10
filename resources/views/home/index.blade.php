@extends('layouts.site')

@section('title', 'Central de Erros - Home')

@section('content')

    <div class="container">
        <div class="flex-center position-ref full-height">
            <div class="content home">
                <div class="title m-b-md" style="font-size: 3.4vw">
                    Central de Erros
                </div>
                <div>
                    @if (Route::has('login'))
                        <div class="links">
                            @auth
                                <h4 style="font-size: 3.4vw">Home</h4>
                            @else
                                <a href="{{ route('login') }}" style="font-size: 1.5vw">Login</a>

                                @if (Route::has('register'))
                                    <a href="{{ route('register') }}" style="font-size: 1.5vw">Cadastro</a>
                                @endif
                            @endauth
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection
