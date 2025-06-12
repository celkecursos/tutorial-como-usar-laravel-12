<?php

namespace App\Console\Commands;

use App\Mail\BirthdayEmail;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;

class SendBirthdayEmail extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:send-birthday-email';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Envia e-mails de aniversário para os usuários aniversariantes do dia';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        // Recuperar a data atual
        $today = Carbon::today();

        // Filtrar usuários cujo dia e mês de nascimento correspondem ao dia atual
        $users = User::whereMonth('date_of_birth', $today->month)
            ->whereDay('date_of_birth', $today->day)
            ->get();

        // Laço de repetição para ler os registros retornado do banco de dados
        foreach ($users as $index => $user) {
            // Mail::to($user->email)->send(new BirthdayEmail($user));
            // $this->info("E-mail enviado para: {$user->name}");
            dispatch(new \App\Jobs\SendBirthdayEmailJob($user))
                ->delay(now()->addSeconds($index * 10)); // atrasa 10s entre cada job;
            $this->info("Job de e-mail enfileirado para: {$user->name}");
        }

        return Command::SUCCESS;
    }
}
