@extends('layouts.login')

@section('content')
    <h1 class="title-login">Nova Senha</h1>

    <x-alert />

    <form class="mt-4" action="{{ route('password.update') }}" method="POST">
        @csrf
        @method('POST')

        <input type="hidden" name="token" value="{{ $token }}">

        <!-- Campo e-mail -->
        <div class="form-group-login">
            <label for="email" class="form-label-login">E-mail</label>
            <input type="email" name="email" id="email" placeholder="Digite o e-mail cadastrado"
                class="form-input-login" value="{{ old('email') }}" required>
        </div>

        <!-- Campo senha -->
        <div class="form-group-login">
            <label for="password" class="form-label-login">Senha</label>
            <input type="password" name="password" id="password" placeholder="Digite a nova senha" class="form-input-login"
                value="{{ old('password') }}" required>
        </div>

        <!-- Campo confirmar senha -->
        <div class="form-group-login">
            <label for="password_confirmation" class="form-label-login">Confirmar Senha</label>
            <input type="password" name="password_confirmation" id="password_confirmation" placeholder="Confirmar a senha" class="form-input-login"
                value="{{ old('password_confirmation') }}" required>
        </div>

        <!-- Link para página de login -->
        <div class="btn-group-login">
            <a href="{{ route('login') }}" class="link-login">Login</a>
            <button type="submit" class="btn-primary-md">Atualizar</button>
        </div>

    </form>
    
@endsection
