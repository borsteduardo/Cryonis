<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Chibi;
use App\Models\InventarioChibi;
use App\Models\Transacao;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class ChibiController extends Controller
{
    // --- LÓGICA DE COMPRA ---
    public function comprarGiro()
    {
        $user = Auth::user();
        $hoje = Carbon::now();

        // Reseta o limite se for uma nova semana
        if ($user->ultima_compra_giro && !$user->ultima_compra_giro->isCurrentWeek()) {
            $user->compras_giro_semana = 0;
        }

        // Verifica Limite Semanal
        if ($user->compras_giro_semana >= 10) {
            return redirect()->back()->with('erro', 'Você já comprou o limite máximo de 10 giros nesta semana. Aguarde o reset semanal!');
        }

        // Calcula Saldo do Banco
        $transacoes = Transacao::where('user_id', $user->id)->get();
        $saldoAtual = $transacoes->where('tipo', 'entrada')->sum('valor') - $transacoes->where('tipo', 'saida')->sum('valor');

        // Verifica se tem dinheiro
        if ($saldoAtual < 25000) {
            return redirect()->back()->with('erro', 'Saldo insuficiente! Você precisa de 25.000 C para comprar um giro.');
        }

        // Debita do Banco e cria o extrato
        Transacao::create([
            'user_id' => $user->id,
            'tipo' => 'saida',
            'valor' => 25000,
            'descricao' => 'Compra de Giro (Banner Chibi)'
        ]);

        // Adiciona o giro ao usuário
        $user->giros_chibi += 1;
        $user->compras_giro_semana += 1;
        $user->ultima_compra_giro = $hoje;
        $user->save();

        return redirect()->back()->with('sucesso', 'Giro comprado com sucesso! Boa sorte!');
    }

    // --- LÓGICA DO SORTEIO (GACHA) ---
    public function girar()
    {
        $user = Auth::user();

        if ($user->giros_chibi <= 0) {
            return response()->json(['erro' => 'Você não tem giros disponíveis.']);
        }

        // A Matemática do Drop
        $rand = rand(1, 1000);
        $raridadeSorteada = '';

        if ($rand <= 500) { $raridadeSorteada = 'Comum'; } 
        elseif ($rand <= 800) { $raridadeSorteada = 'Incomum'; } 
        elseif ($rand <= 920) { $raridadeSorteada = 'Raro'; } 
        elseif ($rand <= 975) { $raridadeSorteada = 'Épico'; } 
        elseif ($rand <= 995) { $raridadeSorteada = 'Lendário'; } 
        elseif ($rand <= 999) { $raridadeSorteada = 'Mítico'; } 
        else { $raridadeSorteada = 'Secreto'; }

        // Busca um chibi aleatório daquela raridade
        $chibi = Chibi::where('raridade', $raridadeSorteada)->inRandomOrder()->first();

        if (!$chibi) {
            return response()->json(['erro' => "O sistema sorteou um {$raridadeSorteada}, mas não há Chibis dessa raridade cadastrados! Fale com a staff."]);
        }

        // Deduz o giro
        $user->giros_chibi -= 1;
        $user->save();

        // Adiciona ao Inventário
        $inventario = InventarioChibi::where('user_id', $user->id)->where('chibi_id', $chibi->id)->first();
        if ($inventario) {
            $inventario->increment('quantidade');
        } else {
            InventarioChibi::create([
                'user_id' => $user->id,
                'chibi_id' => $chibi->id,
                'quantidade' => 1
            ]);
        }

        return response()->json([
            'sucesso' => true,
            'chibi' => $chibi
        ]);
    }

    // --- MÉTODOS DE ADMINISTRAÇÃO ---
    public function store(Request $request)
    {
        Chibi::create($request->all());
        return redirect()->back()->with('sucesso', 'Chibi cadastrado!');
    }

    public function destroy($id)
    {
        Chibi::findOrFail($id)->delete();
        return redirect()->back()->with('sucesso', 'Chibi excluído!');
    }

    // --- TELAS (VIEWS) ---
    public function index()
    {
        $user = Auth::user();
        // Trazemos todos os chibis cadastrados para listar na tela (para os jogadores verem o que podem ganhar)
        $chibis = Chibi::orderBy('nome', 'asc')->get(); 
        
        return view('chibis.index', compact('user', 'chibis'));
    }

    public function inventario()
    {
        $user = Auth::user();
        // Traz o inventário do usuário junto com os dados de cada chibi
        $inventario = InventarioChibi::with('chibi')->where('user_id', $user->id)->get();
        
        return view('chibis.inventario', compact('inventario'));
    }
}