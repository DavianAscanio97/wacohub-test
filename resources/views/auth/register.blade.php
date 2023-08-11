@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card pokemon-card">
                <div class="card-header pokemon-card-header">{{ __('Registro de usuarios') }}</div>

                <div class="card-body">
                    <form method="POST" action="{{ route('register') }}">
                        @csrf

                        <div class="mb-3">
                            <label for="name" class="pokemon-form-label">{{ __('Nombre') }}</label>
                            <input id="name" type="text" class="form-control pokemon-form-input @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}" required autocomplete="name" autofocus>

                            @error('name')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="email" class="pokemon-form-label">{{ __('Dirección de correo electrónico') }}</label>
                            <input id="email" type="email" class="form-control pokemon-form-input @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email">

                            @error('email')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="password" class="pokemon-form-label">{{ __('Contraseña') }}</label>
                            <input id="password" type="password" class="form-control pokemon-form-input @error('password') is-invalid @enderror" name="password" required autocomplete="new-password">

                            @error('password')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="password-confirm" class="pokemon-form-label">{{ __('Confirmar Contraseña') }}</label>
                            <input id="password-confirm" type="password" class="form-control pokemon-form-input" name="password_confirmation" required autocomplete="new-password">
                        </div>

                        <div class="mb-3">
                            <button type="submit" class="btn btn-primary pokemon-btn">
                                {{ __('Registrarse') }}
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
