<?php

namespace App\Jobs;

use App\Mail\WelcomeUserMail;
use App\Models\User;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Support\Facades\Mail;
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

        // Variável para receber o tempo progressivo do envio do e-mail
        $delaySeconds = 0;

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

            // Gerar senha temporária
            $password = Str::random(7);

            // Criar o usuário
            $user = User::create([
                'name' => $name,
                'email' => $email,
                'password' => $password,
            ]);

            // Enviar o e-mail de boas-vindas  
            // Não usar o send para grande quantidade de usuários.
            // Mail::to($email)->send(new WelcomeUserMail($user, $password));          
            
            // Para grande quantidade de usuários, utilizar o queue.
            // Mail::to($email)->queue(new WelcomeUserMail($user, $password)); 
            
            // Para grande quantidade de usuários, usar o later para agendar o envio a cada 10 segundos, com o objetivo de distribuir a carga de envio de muitos e-mails.
            Mail::to($email)->later(now()->addSeconds($delaySeconds), new WelcomeUserMail($user, $password));

            // Incrementa o atraso em 10 segundos para o próximo
            $delaySeconds += 10;

        }
    }
}
