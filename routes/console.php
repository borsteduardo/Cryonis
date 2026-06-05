<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Schedule; // A importação fica só aqui em cima uma vez

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');

// AGENDAMENTO DO NOSSO SALÁRIO
// O comando 'daily' faz rodar todo dia à meia-noite.
Schedule::command('rpg:pagar-salarios')->daily();

// AGENDAMENTO DAS MISSÕES (PASSE DE BATALHA)
Schedule::command('missoes:reset')->dailyAt('00:00');