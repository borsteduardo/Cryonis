<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class RngController extends Controller
{
    // 1. Exibe a tela do Simulador e a Tabela de Líderes
    public function index()
    {
        // Busca os 10 jogadores com os maiores recordes
        $recordes = User::where('maior_numero_rng', '>', 0)
                        ->orderBy('maior_numero_rng', 'desc')
                        ->limit(10)
                        ->get();

        return view('rng.index', compact('recordes'));
    }

    // 2. Roda a roleta e calcula o número
    public function girar()
    {
        $user = Auth::user();
        $numero = 1;

        // A MÁGICA MATEMÁTICA: 50% de chance de subir de nível a cada rodada
        // 1 = 100% (já começa no 1)
        // 2 = 50%
        // 3 = 25%
        // 4 = 12.5% ... e assim por diante
        while (rand(1, 100) <= 50) {
            $numero++;
        }

        $novoRecorde = false;

        // Se o número tirado for maior que o recorde atual do jogador, atualiza
        if ($numero > $user->maior_numero_rng) {
            $user->maior_numero_rng = $numero;
            $user->save();
            $novoRecorde = true;
        }

        // Retorna a resposta para o JavaScript atualizar a tela sem recarregar
        return response()->json([
            'numero' => $numero,
            'novo_recorde' => $novoRecorde,
            'recorde_atual' => $user->maior_numero_rng
        ]);
    }
}