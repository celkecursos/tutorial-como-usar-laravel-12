<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserRequest;
use App\Mail\UserPdfMail;
use App\Models\User;
use Barryvdh\DomPDF\Facade\Pdf;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class UserController extends Controller
{
    // Listar os usuários
    public function index(Request $request)
    {
        // Recuperar os registros do banco dados
        // $users = User::orderByDesc('id')->paginate(10);
        $users = User::when(
            $request->filled('name'),
            fn($query) =>
            $query->whereLike('name', '%' . $request->name . '%')
        )
            ->when(
                $request->filled('email'),
                fn($query) => 
                $query->whereLike('email', '%' . $request->email . '%')
            )
            ->orderByDesc('id')
            ->paginate(10)
            ->withQueryString();

        // Carregar a VIEW
        return view('users.index', [
            'users' => $users,
            'name' => $request->name,
            'email' => $request->email,
        ]);
    }

    // Detalhes do usuario
    public function show(User $user)
    {
        // Carregar a VIEW
        return view('users.show', ['user' => $user]);
    }

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
            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => $request->password
            ]);

            // Redirecionar o usuário, enviar a mensagem de sucesso
            return redirect()->route('user.show', ['user' => $user->id])->with('success', 'Usuário cadastrado com sucesso!');
        } catch (Exception $e) {

            // Redirecionar o usuário, enviar a mensagem de erro
            return back()->withInput()->with('error', 'Usuário não cadastrado!');
        }
    }

    // Carregar o formulário editar usuário
    public function edit(User $user)
    {
        // Carregar a VIEW
        return view('users.edit', ['user' => $user]);
    }

    // Editar no banco de dados o usuário
    public function update(UserRequest $request, User $user)
    {

        try {
            // Editar as informações do registro no banco de dados
            $user->update([
                'name' => $request->name,
                'email' => $request->email,
            ]);

            // Redirecionar o usuário, enviar a mensagem de sucesso
            return redirect()->route('user.show', ['user' => $user->id])->with('success', 'Usuário editado com sucesso!');
        } catch (Exception $e) {

            // Redirecionar o usuário, enviar a mensagem de erro
            return back()->withInput()->with('error', 'Usuário não editado!');
        }
    }

    // Carregar o formulário editar senha do usuário
    public function editPassword(User $user)
    {

        // Carregar a VIEW
        return view('users.editPassword', ['user' => $user]);
    }

    // Editar no banco de dados a senha do usuário
    public function updatePassword(Request $request, User $user)
    {

        // Validar o formulário
        $request->validate([
            'password' => 'required|min:6',
        ], [
            'password.required' => 'O campo senha é obrigatório.',
            'password.min' => 'A senha deve ter pelo menos :min caracteres.',
        ]);

        try {

            // Editar as informações do registro no banco de dados
            $user->update([
                'password' => $request->password,
            ]);

            // Redirecionar o usuário, enviar a mensagem de sucesso
            return redirect()->route('user.show', ['user' => $user->id])->with('success', 'Senha do usuário editada com sucesso!');
        } catch (Exception $e) {

            // Redirecionar o usuário, enviar a mensagem de erro
            return back()->withInput()->with('error', 'Senha do usuário não editada!');
        }
    }

    // Excluir o usuário do banco de dados
    public function destroy(User $user)
    {
        try {
            // Excluir o registro do banco de dados
            $user->delete();

            // Redirecionar o usuário, enviar a mensagem de sucesso
            return redirect()->route('user.index')->with('success', 'Usuário excluído com sucesso!');
        } catch (Exception $e) {

            // Redirecionar o usuário, enviar a mensagem de erro
            return redirect()->route('user.index')->with('error', 'Usuário não excluído!');
        }
    }

    // Gerar PDF
    public function generatePdf(User $user)
    {
        try {
            // Carregar a string com o HTML/conteúdo e determinar a orientação e o tamanho do arquivo
            $pdf = Pdf::loadView('users.genenate-pdf', ['user' => $user])->setPaper('a4', 'portrait');

            // Definir o caminho temporário para salvar o arquivo
            $pdfPath = storage_path("app/public/view_user_{$user->id}.pdf");

            // Salvar o PDF localmente
            $pdf->save($pdfPath);

            // Enviar e-mail com o PDF anexado
            Mail::to($user->email)->send(new UserPdfMail($pdfPath, $user));

            // Remover o arquivo após o envio do e-mail
            if (file_exists($pdfPath)) {
                unlink($pdfPath);
            }

            // Redirecionar o usuário, enviar a mensagem de sucesso
            return redirect()->route('user.show', ['user' => $user->id])->with('success', 'E-mail enviado com sucesso!');
        } catch (Exception $e) {

            // Redirecionar o usuário, enviar a mensagem de erro
            return redirect()->route('user.show', ['user' => $user->id])->with('error', 'E-mail não enviado!');
        }
    }
}
