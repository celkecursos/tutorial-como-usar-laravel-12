<?php

namespace App\Http\Controllers;

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
        try {

            // Validar o arquivo
            $request->validate([
                'file' => 'required|mimes:csv,txt|max:2048',
            ], [
                'file.required' => 'O campo arquivo é obrigatório.',
                'file.mimes' => 'Arquivo inválido, necessário enviar arquivo CSV.',
                'file.max' => 'Tamanho do arquivo execede :max Mb.'
            ]);

            // Criar o array com as colunas no banco de dados
            $headers = ['name', 'email', 'password'];

            // Receber o arquivo, ler os dados e converter a string em array
            $fileData = array_map('str_getcsv', file($request->file('file')));

            // Definir o separador dos valores no CSV
            $separator = ';';

            // Criar array para armazenar os valores que serão inseridos no banco
            $arrayValues = [];

            // Criar array para armazenar e-mails duplicados encontrados
            $duplicatedEmails = [];

            // Criar variável para contar o número de registros que serão cadastrados
            $numberRegisteredRecords = 0;

            // Percorrer cada linha do arquivo CSV
            foreach ($fileData as $row) {

                // Separar os valores da linha utilizando o separador
                $values = explode($separator, $row[0]);

                // Verificar se a quantidade de valores corresponde ao número de colunas esperadas
                if (count($values) !== count($headers)) {
                    continue; // Ignora linhas inválidas
                }

                // Combinar os valores com os nomes das colunas (cabeçalhos)
                $userData = array_combine($headers, $values);

                // Consulta apenas o e-mail atual para verificar se já existe no banco de dados
                $emailExists = User::where('email', $userData['email'])->exists();

                // Se o e-mail já existir, adicionar na lista de e-mails duplicados e pular para a próxima linha
                if ($emailExists) {
                    $duplicatedEmails[] = $userData['email'];
                    continue;
                }

                // Adicionar o usuário ao array de valores para serem inseridos
                $arrayValues[] = [
                    'name' => $userData['name'],
                    'email' => $userData['email'],
                    'password' => Hash::make(Str::random(7), ['rounds' => 12]),
                    'created_at' => now(),
                    'updated_at' => now(),
                ];
                // Incrementar o contador de registros que serão cadastrados
                $numberRegisteredRecords++;
            }

            // Verificar se existe e-mail já cadastrado, retorna erro e não cadastra no banco de dados
            if (!empty($duplicatedEmails)) {
                // Redirecionar o usuário, enviar a mensagem de erro
                return back()->with('error', 'Dados não importados. Existem e-mails já cadastrados:<br>' . implode(', ', $duplicatedEmails));
            }

            // Cadastrar registros no banco de dados
            User::insert($arrayValues);

            // Redirecionar o usuário, enviar a mensagem de sucesso
            return back()->with('success', 'Dados importados com sucesso. <br>Quantidade: ' . $numberRegisteredRecords);
        } catch (Exception $e) {

            // Redirecionar o usuário, enviar a mensagem de erro
            return back()->withInput()->with('error', 'Dados não importados!');
        }
    }
}
