@extends('layouts.admin')

@section('content')   

        <div class="content">
            <div class="content-title">
                <h1 class="page-title">Editar Usuário</h1>
                <a href="{{ route('user.index') }}" class="btn-info">Listar</a>
            </div>

            <x-alert />

            <form action="{{ route('user.update-password', ['user' => $user->id ]) }}" method="POST" class="form-container">
                @csrf
                @method('PUT')

                <div class="mb-4">
                    <label for="password" class="form-label">Senha:</label>
                    <input type="password" name="password" id="password" class="form-input"
                        placeholder="Senha com no mínimo 6 caracteres" value="{{ old('password') }}" >
                </div>

                <button type="submit" class="btn-warning">Salvar</button>
            </form>
        </div>
@endsection
