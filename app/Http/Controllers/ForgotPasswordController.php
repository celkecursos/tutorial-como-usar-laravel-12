<?php

namespace App\Http\Controllers;

use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Password;

class ForgotPasswordController extends Controller
{
    // Formulário para receber o link recuperar senha
    public function showLinkRequestForm()
    {
        // Carregar a VIEW
        return view('auth.forgot_password');
    }

    // Receber dados do formulário recuperar senha
    public function sendResetLinkEmail(Request $request)
    {
        // Validar o formulário
        $request->validate([
            'email' => 'required|email',
        ], [
            'email.required' => "Campo e-mail é obrigatório!",
            'email.email' => "Necessário enviar e-mail válido!",
        ]);

        // Verificar se existe usuário no banco de dados com o e-mail
        $user = User::where('email', $request->email)->first();

        // Verificar se encontrou o usuário
        if (!$user) {

            // Redirecionar o usuário, enviar a mensagem de erro
            return back()->withInput()->with('error', 'E-mail não encontrado!');
        }

        try {
            // Salvar o token recuperar senha e enviar e-mail
            Password::sendResetLink(
                // Retorna um array associativo contendo apenas o campo "email" da requisição.
                $request->only('email')
            );

            // Redirecionar o usuário, enviar a mensagem de sucesso
            return redirect()->route('login')->with('success', 'Enviado e-mail com instruções para recuperar a senha. Acesse a sua caixa de e-mail para recuperar a senha!');
        } catch (Exception $e) {

            // Redirecionar o usuário, enviar a mensagem de erro
            return back()->withInput()->with('error', 'Tente mais tarde!');
        }
    }

    // Carregar o formulário atualizar senha
    public function showRequestForm(Request $request)
    {
        try {
            // Recuperar os dados do usuário no banco de dados através do e-mail
            $user = User::where('email', $request->email)->first();

            // Verificar se encontrou o usuário no BD e o token é válido
            if (!$user || !Password::tokenExists($user, $request->token)) {

                // Redirecionar o usuário, enviar a mensagem de sucesso
                return redirect()->route('login')->with('error', 'Token inválido ou expirado!');
            }

            // Carregar a VIEW
            return view('auth.reset_password', ['token' => $request->token, 'email' => $request->email]);
        } catch (Exception $e) {

            // Redirecionar o usuário, enviar a mensagem de erro
            return redirect()->route('login')->with('error', 'Token inválido ou expirado!');
        }
    }

    public function reset(Request $request)
    {
        // Validar o formulário
        $request->validate([
            'email' => 'required|email|exists:users',
            'password' => 'required|confirmed|min:6',
        ], [
            'email.required' => "Campo e-mail é obrigatório!",
            'email.email' => "Necessário enviar e-mail válido!",
            'email.exists' => "E-mail inválido, utilize o e-mail cadastrado!",
            'password.required' => "Campo senha é obrigatório!",
            'password.confirmed' => 'A confirmação da senha não corresponde!',
            'password.min' => "Senha com no mínimo :min caracteres!",
        ]);

        try {
            // reset - Redefinir a senha do usuário
            $status = Password::reset(
                // only - Recuperar apenas os campos específicos do pedido: 'email', 'password', 'password_confirmation' e 'token'.
                $request->only('email', 'password', 'password_confirmation', 'token'),

                // Retornar o callback se a redefinição de senha for bem-sucedida
                function(User $user, string $password){
                    // forceFill - Forçar o acesso a atributos protegidos
                    $user->forceFill([
                        'password' => $password
                    ]);

                    // Salvar as alterações
                    $user->save();
                }
            );

            // Redirecionar o usuário, enviar a mensagem de sucesso ou erro
            // return $status === Password::PASSWORD_RESET ? redirect()->route('login')->with('success', 'Senha atualizada com sucesso!') : redirect()->route('login')->with('error', __($status));
            return $status === Password::PASSWORD_RESET ? redirect()->route('login')->with('success', 'Senha atualizada com sucesso!') : redirect()->route('login')->with('error', 'Senha não atualizada!');

        } catch (Exception $e) {

            // Redirecionar o usuário, enviar a mensagem de erro
            return back()->withInput()->with('error', 'Tente mais tarde!');
        }
    }

}
