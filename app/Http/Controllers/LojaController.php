<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Ficha;
use App\Models\SolicitacaoCompra;
use App\Models\Transacao;
use App\Models\Inventario;
use Illuminate\Support\Facades\Auth;

class LojaController extends Controller
{
    // 1. O Jogador clica em "Solicitar Compra"
    public function solicitar(Request $request, $ficha_id)
    {
        $ficha = Ficha::findOrFail($ficha_id);
        $user = Auth::user();

        // Verifica se a carta é exclusiva de outro personagem
        if ($ficha->usuario_exclusivo && !str_contains(strtolower($user->name), strtolower($ficha->usuario_exclusivo))) {
            return redirect()->back()->with('erro', 'Esta carta é de uso exclusivo de ' . $ficha->usuario_exclusivo . '.');
        }

        // Verifica se ele já tem um pedido pendente dessa mesma carta para evitar spam
        $jaPediu = SolicitacaoCompra::where('user_id', $user->id)
                                    ->where('ficha_id', $ficha->id)
                                    ->where('status', 'pendente')
                                    ->exists();

        if ($jaPediu) {
            return redirect()->back()->with('erro', 'Você já tem uma solicitação pendente para esta carta. Aguarde a aprovação.');
        }

        // Cria o pedido
        SolicitacaoCompra::create([
            'user_id' => $user->id,
            'ficha_id' => $ficha->id,
            'status' => 'pendente'
        ]);

        return redirect()->back()->with('sucesso', 'Solicitação enviada! Aguarde um Conselheiro ou Ficheiro aprovar.');
    }

    // 2. Tela de Painel para os Conselheiros/Ficheiros verem os pedidos
    public function painelAprovacao()
    {
        // Traz todos os pedidos pendentes com as informações do jogador e da carta
        $solicitacoes = SolicitacaoCompra::with(['user', 'ficha'])
                                         ->where('status', 'pendente')
                                         ->orderBy('created_at', 'asc')
                                         ->get();

        return view('loja.painel', compact('solicitacoes'));
    }

    // 3. Conselheiro aprova a compra
    public function aprovar($id)
    {
        $solicitacao = SolicitacaoCompra::findOrFail($id);
        $ficha = $solicitacao->ficha;
        $comprador = $solicitacao->user;

        // CALCULA O SALDO DO COMPRADOR
        $transacoes = Transacao::where('user_id', $comprador->id)->get();
        $saldoAtual = $transacoes->where('tipo', 'entrada')->sum('valor') - $transacoes->where('tipo', 'saida')->sum('valor');

        // Verifica se ele tem Coins suficientes
        if ($saldoAtual < $ficha->preco) {
            return redirect()->back()->with('erro', "O jogador {$comprador->name} não tem Coins suficientes. Saldo: {$saldoAtual} C | Preço: {$ficha->preco} C");
        }

        // DESCONTA O DINHEIRO (Cria uma transação de saída)
        if ($ficha->preco > 0) {
            Transacao::create([
                'user_id' => $comprador->id,
                'tipo' => 'saida',
                'valor' => $ficha->preco,
                'descricao' => "Compra de Carta: {$ficha->titulo}"
            ]);
        }

        // ADICIONA AO INVENTÁRIO
        $itemExistente = Inventario::where('user_id', $comprador->id)->where('ficha_id', $ficha->id)->first();
        if ($itemExistente) {
            $itemExistente->increment('quantidade'); // Se já tem a carta, aumenta a quantidade
        } else {
            Inventario::create([
                'user_id' => $comprador->id,
                'ficha_id' => $ficha->id,
                'quantidade' => 1
            ]);
        }

        // MARCA COMO APROVADA
        $solicitacao->update(['status' => 'aprovada']);

        return redirect()->back()->with('sucesso', "Compra de {$ficha->titulo} aprovada para {$comprador->name}!");
    }

    // 4. Conselheiro recusa a compra
    public function recusar($id)
    {
        $solicitacao = SolicitacaoCompra::findOrFail($id);
        $solicitacao->update(['status' => 'recusada']);

        return redirect()->back()->with('sucesso', 'Solicitação recusada e fechada.');
    }
}