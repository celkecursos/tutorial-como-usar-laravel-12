@extends('layouts.admin')

@section('content')
    <div class="content">
        <div class="content-title">
            <h1 class="page-title">Cadastrar Usuário</h1>
            <a href="{{ route('user.index') }}" class="btn-info">Listar</a>
        </div>

        <x-alert />

        <form action="{{ route('user.store') }}" method="POST" class="form-container">
            @csrf

            <div class="mb-4">
                <label for="name" class="form-label">Nome:</label>
                <input type="text" name="name" id="name" class="form-input"
                    placeholder="Nome completo do usuário" value="{{ old('name') }}">
            </div>

            <div class="mb-4">
                <label for="email" class="form-label">E-mail:</label>
                <input type="email" name="email" id="email" class="form-input"
                    placeholder="Melhor e-mail do usuário" value="{{ old('email') }}">
            </div>

            <div class="mb-4">
                <label for="password" class="form-label">Senha:</label>
                <input type="password" name="password" id="password" class="form-input"
                    placeholder="Senha com no mínimo 6 caracteres" value="{{ old('password') }}">
            </div>

            <div class="mb-4">
                <label for="date_of_birth" class="form-label">Data de Nascimento:</label>
                <input type="date" name="date_of_birth" id="date_of_birth" class="form-input" value="{{ old('date_of_birth') }}">
            </div>

            <div class="mb-4">
                <label for="description" class="form-label">Descrição:</label>
                <textarea name="description" id="summernote" class="form-input">{{ old('description') }}</textarea>
            </div>

            <button type="submit" class="btn-success">Cadastrar</button>
        </form>
    </div>
@endsection

{{-- Lorem ipsum dolor sit amet consectetur adipisicing elit. Veritatis ratione necessitatibus consequatur quas autem temporibus tenetur accusamus, voluptas nisi expedita sit quo adipisci, iste esse quasi a laborum excepturi nesciunt. --}}
