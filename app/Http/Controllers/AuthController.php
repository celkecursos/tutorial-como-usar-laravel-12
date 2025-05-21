<?php

namespace App\Http\Controllers;

use App\Http\Requests\AuthLoginRequest;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    // Login
    public function index()
    {
        // Carregar a VIEW
        return view('auth.login');
    }

    // Validar os dados do usuário no login
    public function loginProcess(AuthLoginRequest $request)
    {
        // Capturar possíveis exceções durante a execução.
        try {
            // Validar o usuário e a senha com as informações do banco de dados
            $authenticated = Auth::attempt([
                'email' => $request->email,
                'password' => $request->password
            ]);

            // Verificar se o usuário foi autenticado
            if (!$authenticated) {
                // Redirecionar o usuário, enviar a mensagem de erro
                return back()->withInput()->with('error', 'E-mail ou senha inválido!');
            }

            // Redirecionar o usuário
            return redirect()->route('user.index');
        } catch (Exception $e) {
            // Redirecionar o usuário, enviar a mensagem de erro
            return back()->withInput()->with('error', 'E-mail ou senha inválido!');
        }
    }

    // Deslogar o usuário
    public function logout()
    {

        // Deslogar o usuário
        Auth::logout();

        // Redirecionar o usuário, enviar a mensagem de sucesso
        return redirect()->route('login')->with('success', 'Deslogado com sucesso!');
    }
}
