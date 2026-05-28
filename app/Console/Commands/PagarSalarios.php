<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\User;
use App\Models\Transacao;

class PagarSalarios extends Command
{
    // O nome do comando que você poderá rodar no terminal para testar
    protected $signature = 'rpg:pagar-salarios';
    protected $description = 'Paga o salário diário de todos os membros de acordo com a patente';

    public function handle()
    {
        // Define o valor do salário para cada patente (Você pode alterar esses valores livremente)
        $salarios = [
            'Conselheiro' => 500.00,
            'Banqueiro'   => 350.00,
            'Ficheiro'    => 200.00,
            'Mestre'      => 150.00,
            'Membro'      => 100.00,
        ];

        // Puxa todos os jogadores do banco
        $jogadores = User::all();

        foreach ($jogadores as $jogador) {
            // Verifica se a patente do jogador existe na nossa lista de salários
            if (array_key_exists($jogador->patente, $salarios)) {
                $valorSalario = $salarios[$jogador->patente];

                // Cria a transação de entrada automática
                Transacao::create([
                    'user_id'   => $jogador->id,
                    'tipo'      => 'entrada',
                    'valor'     => $valorSalario,
                    'descricao' => 'Salário Diário Automático (' . $jogador->patente . ')',
                ]);
            }
        }

        // Mostra uma mensagem de sucesso no terminal
        $this->info('Salários pagos com sucesso para ' . $jogadores->count() . ' jogadores!');
    }
}