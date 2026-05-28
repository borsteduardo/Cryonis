<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Schedule; // Adicione esta linha no topo se não existir

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote')->hourly();

// AGENDAMENTO DO NOSSO SALÁRIO
// O comando 'daily' faz rodar todo dia à meia-noite.
Schedule::command('rpg:pagar-salarios')->daily();