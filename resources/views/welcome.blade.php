@extends('layouts.admin')

@section('content')
    <h1>Bem-vindo à Celke!</h1>

    <a href="{{ route('user.create') }}">Cadastrar</a>
@endsection
