<?php

namespace App\Http\Controllers;

use App\Models\HomeSection;
use Exception;
use Illuminate\Http\Request;

class SiteController extends Controller
{
    // Página inicial do site
    public function home()
    {

        // Recuperar o conteúdo para a página do site
        $homeSection = HomeSection::latest()->first();

        // Carregar a VIEW
        return view('site.home', [ 'homeSection' => $homeSection]);
    }

    // Carregar o formulário editar o conteúdo da página inicial do site
    public function edit()
    {

        // Recuperar o conteúdo para a página do site
        $homeSection = HomeSection::latest()->first();

        // Carregar a VIEW
        return view('site.edit-home', ['homeSection' => $homeSection]);
    }

    // Editar no banco de dados
    public function update(Request $request)
    {
        // Validação simples (pode ser substituída por um FormRequest personalizado)
        $validated = $request->validate([
            'main_title' => 'required|string|max:255',
            'main_description' => 'required|string',
            'feature_one_title' => 'required|string|max:255',
            'feature_one_description' => 'required|string',
            'feature_two_title' => 'required|string|max:255',
            'feature_two_description' => 'required|string',
            'feature_three_title' => 'required|string|max:255',
            'feature_three_description' => 'required|string',
        ], [
            'main_title.required' => 'O campo Título Principal é obrigatório.',
            'main_title.max' => 'O campo Título Principal deve ter no máximo 255 caracteres.',
            'main_description.required' => 'O campo Descrição Principal é obrigatório.',

            'feature_one_title.required' => 'O campo Título do Recurso 1 é obrigatório.',
            'feature_one_title.max' => 'O campo Título do Recurso 1 deve ter no máximo 255 caracteres.',
            'feature_one_description.required' => 'O campo Descrição do Recurso 1 é obrigatório.',

            'feature_two_title.required' => 'O campo Título do Recurso 2 é obrigatório.',
            'feature_two_title.max' => 'O campo Título do Recurso 2 deve ter no máximo 255 caracteres.',
            'feature_two_description.required' => 'O campo Descrição do Recurso 2 é obrigatório.',

            'feature_three_title.required' => 'O campo Título do Recurso 3 é obrigatório.',
            'feature_three_title.max' => 'O campo Título do Recurso 3 deve ter no máximo 255 caracteres.',
            'feature_three_description.required' => 'O campo Descrição do Recurso 3 é obrigatório.',
        ]);

        try {
            // Busca o primeiro registro (supondo que só exista um)
            $homeSection = HomeSection::first();

            // Se não existir, cria um novo
            if (!$homeSection) {
                $homeSection = new HomeSection();
            }

            // Preenche e salva
            $homeSection->fill($validated);
            $homeSection->save();

            return redirect()
                ->route('site-home.edit') // ou .show dependendo da sua rota
                ->with('success', 'Conteúdo atualizado com sucesso!');
        } catch (Exception $e) {
            return back()
                ->withInput()
                ->with('error', 'Erro ao atualizar o conteúdo!');
        }
    }
}
