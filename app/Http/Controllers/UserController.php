<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserRequest;
use App\Models\User;
use Exception;

class UserController extends Controller
{
    // Carregar o formulário cadastrar novo usuário
    public function create()
    {
        // Carregar a VIEW
        return view('users.create');
    }

    // Cadastrar no banco de dados o novo registro
    public function store(UserRequest $request)
    {
        // dd($request);

        try {

            // Cadastrar no banco de dados na tabela usuários
            User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => $request->password
            ]);

            // Redirecionar o usuário, enviar a mensagem de sucesso
            return redirect()->route('user.create')->with('success', 'Usuário cadastrado com sucesso!');

        } catch (Exception $e) {

            // Redirecionar o usuário, enviar a mensagem de erro
            return back()->withInput()->with('error', 'Usuário não cadastrado!');
        }
    }
}
