<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Transacao;
use App\Models\User; // <-- ADICIONAMOS ISSO para poder buscar os usuários
use Illuminate\Support\Facades\Auth;

class BancoController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        // Busca o extrato e o saldo apenas de quem está visualizando a tela
        $transacoes = Transacao::where('user_id', $user->id)->orderBy('created_at', 'desc')->get();
        $entradas = $transacoes->where('tipo', 'entrada')->sum('valor');
        $saidas = $transacoes->where('tipo', 'saida')->sum('valor');
        $saldo = $entradas - $saidas;

        // Busca todos os jogadores cadastrados em ordem alfabética para o formulário
        $todosJogadores = User::orderBy('name')->get();

        // Enviamos a nova variável $todosJogadores para a tela
        return view('banco.index', compact('transacoes', 'saldo', 'todosJogadores'));
    }

    public function store(Request $request)
    {
        // 1. A validação agora espera uma lista (array) de IDs
        $request->validate([
            'jogadores_id' => 'required|array', // Tem que ser uma lista
            'jogadores_id.*' => 'exists:users,id', // Cada ID da lista tem que existir no banco
            'tipo' => 'required|in:entrada,saida',
            'valor' => 'required|numeric|min:0.01',
            'descricao' => 'required|string|max:255',
        ]);

        // 2. Proteção contra Saldo Negativo (Verifica todos antes de fazer qualquer transação)
        if ($request->tipo === 'saida') {
            foreach ($request->jogadores_id as $id) {
                $transacoesAlvo = Transacao::where('user_id', $id)->get();
                $entradas = $transacoesAlvo->where('tipo', 'entrada')->sum('valor');
                $saidas = $transacoesAlvo->where('tipo', 'saida')->sum('valor');
                $saldoAtual = $entradas - $saidas;

                if ($request->valor > $saldoAtual) {
                    $jogadorFalho = User::find($id);
                    return redirect()->back()->with('erro', "Transação cancelada: O jogador {$jogadorFalho->name} não possui Coins suficientes para esta saída.");
                }
            }
        }

        // 3. Se passou no teste, cria a transação para cada jogador marcado
        foreach ($request->jogadores_id as $id) {
            Transacao::create([
                'user_id' => $id, 
                'tipo' => $request->tipo,
                'valor' => $request->valor,
                'descricao' => $request->descricao,
            ]);
        }

        return redirect()->back()->with('sucesso', 'Transações registradas com sucesso para os jogadores selecionados!');
    }
}