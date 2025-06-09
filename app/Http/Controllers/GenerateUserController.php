<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class GenerateUserController extends Controller
{
    // Gerar e cadastrar usuário
    public function index()
    {
        // Cadastrar o usuário no banco de dados
        User::create([
            'name' => fake()->name(),
            'email' => fake()->unique()->safeEmail(),
            'password' => Hash::make('password'),
            'remember_token' => Str::random(10),
            'description' => fake()->text(),
        ]);
    }
}
