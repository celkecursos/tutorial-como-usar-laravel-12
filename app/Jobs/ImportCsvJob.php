<?php

namespace App\Jobs;

use App\Models\User;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use League\Csv\Reader;
use League\Csv\Statement;

class ImportCsvJob implements ShouldQueue
{
    use Queueable;

    /**
     * Create a new job instance.
     */
    public function __construct( protected $filePath )
    {
        //
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        // Define o caminho completo do arquivo CSV armazenado no diretório 'storage/app/private'
        $filePath = storage_path('app/private/' . $this->filePath);

        // Verifica se o arquivo realmente existe; se não existir, finaliza o Job sem fazer nada
        if(!file_exists($filePath)){
            return;
        }

        // Cria uma instância do leitor de CSV a partir do caminho do arquivo, sem abrir diretamente
        $csv = Reader::createFromPath($filePath, 'r');

        // Define o delimitador de campos como ponto e vírgula
        $csv->setDelimiter(';');

        // Indica que a primeira linha do CSV será usada como cabeçalho (nomes das colunas)
        $csv->setHeaderOffset(0);

        // Processa o arquivo CSV e retorna os registros como uma coleção iterável
        $records = (new Statement())->process($csv);

        // Inicializa um array para armazenar os dados que serão inseridos em lote
        $batchInsert = [];

        // Itera sobre cada linha do arquivo CSV
        foreach ($records as $record){
            // Obtém o valor da coluna 'email', ou null se não existir
            $email = $record['email'] ?? null;

            // Obtém o valor da coluna 'name', ou null se não existir
            $name = $record['name'] ?? null;

            // Valida se o e-mail existe e se está no formato correto
            if (!$email || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
                // Pula para o próximo registro se o e-mail for inválido
                continue;
            }

            // Verifica se já existe um usuário com esse e-mail no banco
            if (User::where('email', $email)->exists()) {
                // Pula para o próximo se o e-mail já estiver cadastrado
                continue; 
            }

            // Adiciona os dados do novo usuário no array de inserção em lote
            $batchInsert[] = [
                'name' => $name,
                'email' => $email,
                'password' => Hash::make(Str::random(7), ['rounds' => 12]), // Gera uma senha aleatória segura
            ];

            // Se já existem 50 registros prontos, faz a inserção em lote no banco de dados
            if (count($batchInsert) >= 50) {
                // Insere os usuários no banco
                User::insert($batchInsert); 
                // Limpa o array para os próximos 50
                $batchInsert = [];
            }
        }

        // Após o loop, insere os registros restantes que ficaram abaixo de 50
        if (!empty($batchInsert)) {
            // Insere os usuários no banco
            User::insert($batchInsert); 
            // Limpa o array para os próximos 50
            $batchInsert = [];
        }
    }
}
