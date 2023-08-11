@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center p-4">
        <div class="col-4">
            <div class="list-group">
                <a href="{{ route('users.index') }}" class="list-group-item list-group-item-action @if(Route::is('users.index')) active @endif" aria-current="true">Usuarios</a>
                <a href="{{ route('pokemon.index') }}" class="list-group-item list-group-item-action @if(Route::is('pokemon.index')) active @endif">Pokemones</a>
            </div>
        </div>
        <div class="col-md-8">
            <div id="alerts-container"></div>
            @yield('components')
        </div>
    </div>
</div>
@endsection
