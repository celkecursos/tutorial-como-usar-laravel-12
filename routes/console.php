<?php

use Illuminate\Support\Facades\Schedule;

// Execute a tarefa a cada minuto.
Schedule::command('app:send-birthday-email')->everyMinute();

// Executar a tarefa uma vez ao dia as 08:00
// Schedule::command('app:send-birthday-email')->dailyAt('08:00')
//     ->description('Enviar e-mail de aniversário diariamente às 08:00');

// use Illuminate\Foundation\Inspiring;
// use Illuminate\Support\Facades\Artisan;

// Artisan::command('inspire', function () {
//     $this->comment(Inspiring::quote());
// })->purpose('Display an inspiring quote');
