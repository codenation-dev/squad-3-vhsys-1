@extends('layouts.site')

@section('title', 'Central de Erros - Home')

@section('content')

    <div class="container">
        <div class="flex-center position-ref full-height">
            <div class="content">
                <div class="title m-b-md">
                    Central de Erros
                </div>
                <div>
                    @if (Route::has('login'))
                        <div class="links">
                            @auth
                                <h4>Home</h4>
                            @else
                                <a href="{{ route('login') }}">Login</a>

                                @if (Route::has('register'))
                                    <a href="{{ route('register') }}">Register</a>
                                @endif
                            @endauth
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection
