<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\UserMissao;
use App\Models\Missao;
use Carbon\Carbon;

class ResetMissoes extends Command
{
    // O nome que você digitará no terminal para rodar o comando
    protected $signature = 'missoes:reset';

    // A descrição do que ele faz
    protected $description = 'Reseta o progresso das missões diárias, semanais e mensais para que os jogadores possam fazê-las novamente.';

    public function handle()
    {
        $hoje = Carbon::now();

        // 1. RESET DIÁRIO (Roda todo dia)
        $missoesDiariasIds = Missao::where('tipo', 'diaria')->pluck('id');
        if ($missoesDiariasIds->isNotEmpty()) {
            UserMissao::whereIn('missao_id', $missoesDiariasIds)->delete();
            $this->info('Missões diárias resetadas com sucesso.');
        }

        // 2. RESET SEMANAL (Roda apenas se hoje for Segunda-feira)
        if ($hoje->isMonday()) {
            $missoesSemanaisIds = Missao::where('tipo', 'semanal')->pluck('id');
            if ($missoesSemanaisIds->isNotEmpty()) {
                UserMissao::whereIn('missao_id', $missoesSemanaisIds)->delete();
                $this->info('Missões semanais resetadas com sucesso.');
            }
        }

        // 3. RESET MENSAL (Roda apenas se hoje for o dia 1 do mês)
        if ($hoje->day === 1) {
            $missoesMensaisIds = Missao::where('tipo', 'mensal')->pluck('id');
            if ($missoesMensaisIds->isNotEmpty()) {
                UserMissao::whereIn('missao_id', $missoesMensaisIds)->delete();
                $this->info('Missões mensais resetadas com sucesso.');
            }
        }

        $this->info('Rotina de reset de missões concluída!');
    }
}