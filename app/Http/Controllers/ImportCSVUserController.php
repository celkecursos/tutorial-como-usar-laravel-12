<?php

namespace App\Http\Controllers;

use App\Jobs\ImportCsvJob;
use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;

class ImportCSVUserController extends Controller
{
    // Importar os dados do Excel
    public function importCSVUsers(Request $request)
    {
        // Validar o arquivo
        $request->validate([
            'file' => 'required|mimes:csv,txt|max:8192', // 8 MB
        ], [
            'file.required' => 'O campo arquivo é obrigatório.',
            'file.mimes' => 'Arquivo inválido, necessário enviar arquivo CSV.',
            'file.max' => 'Tamanho do arquivo execede :max Mb.'
        ]);

        try {

            // Gerar um nome de arquivo baseado na data e hora atual
            $fileName = 'import-' . now()->format('Y-m-d-H-i-s') . '.csv';

            // Receber o arquivo e movê-lo para o servidor
            $path = $request->file('file')->storeAs('uploads', $fileName);

            // Despachar o Job para processar o CSV
            ImportCsvJob::dispatch($path);

            // Redirecionar o usuário, enviar a mensagem de sucesso
            return back()->withInput()->with('success', 'Dados estão sendo importados!');

        } catch (Exception $e) {

            // Redirecionar o usuário, enviar a mensagem de erro
            return back()->withInput()->with('error', 'Dados não importados!');
        }
    }
}
