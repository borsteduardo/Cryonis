<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Passe;
use App\Models\UserPasse;
use App\Models\Missao;
use App\Models\UserMissao;
use App\Models\PasseNivel;
use App\Models\Transacao;
use App\Models\InventarioChibi;
use Illuminate\Support\Facades\Auth;


class PasseController extends Controller
{
    // 1. Exibe a tela do Passe para o jogador
    public function index()
    {
        $user = Auth::user();
        
        // Busca a temporada ativa
        $passeAtivo = Passe::with(['niveis', 'missoes'])->where('ativo', true)->first();

        if (!$passeAtivo) {
            return view('passe.index', ['passeAtivo' => null]);
        }

        // Busca ou cria o progresso do jogador nesta temporada
        $progresso = UserPasse::firstOrCreate(
            ['user_id' => $user->id, 'passe_id' => $passeAtivo->id],
            ['xp_atual' => 0, 'nivel_atual' => 0, 'premium_desbloqueado' => false]
        );

        // Busca o histórico de missões do jogador para saber o que ele já fez
        // Busca o histórico de missões com o status atual de cada uma
        $statusMissoes = UserMissao::where('user_id', $user->id)->pluck('status', 'missao_id')->toArray();

        return view('passe.index', compact('passeAtivo', 'progresso', 'statusMissoes'));
    }

    // 2. O jogador clica em "Coletar" na missão
    // O jogador apenas solicita a verificação da missão
    public function solicitarVerificacao(Request $request, $missao_id)
    {
        $user = Auth::user();
        
        $jaExiste = UserMissao::where('user_id', $user->id)->where('missao_id', $missao_id)->first();
        if ($jaExiste) {
            return redirect()->back()->with('erro', 'Você já solicitou ou completou esta missão!');
        }

        UserMissao::create([
            'user_id' => $user->id,
            'missao_id' => $missao_id,
            'status' => 'pendente' // Fica aguardando a staff
        ]);

        return redirect()->back()->with('sucesso', 'Missão enviada para a verificação da Staff!');
    }


    // 5. COMPRAR O PASSE PREMIUM
    public function comprarPremium(Request $request)
    {
        $user = Auth::user();
        $passeAtivo = Passe::where('ativo', true)->first();

        if (!$passeAtivo) {
            return redirect()->back()->with('erro', 'Nenhuma temporada ativa no momento.');
        }

        $progresso = UserPasse::firstOrCreate(
            ['user_id' => $user->id, 'passe_id' => $passeAtivo->id],
            ['xp_atual' => 0, 'nivel_atual' => 0, 'premium_desbloqueado' => false]
        );

        if ($progresso->premium_desbloqueado) {
            return redirect()->back()->with('erro', 'Você já possui o Passe Premium desta temporada!');
        }

        // Definindo o preço do Passe Premium (Altere como preferir)
        $precoPremium = 100000; 

        // Verifica Saldo
        $transacoes = Transacao::where('user_id', $user->id)->get();
        $saldoAtual = $transacoes->where('tipo', 'entrada')->sum('valor') - $transacoes->where('tipo', 'saida')->sum('valor');

        if ($saldoAtual < $precoPremium) {
            return redirect()->back()->with('erro', 'Saldo insuficiente! O Passe Premium custa ' . number_format($precoPremium, 0, ',', '.') . ' C.');
        }

        // Debita do Banco e gera o extrato
        Transacao::create([
            'user_id' => $user->id,
            'tipo' => 'saida',
            'valor' => $precoPremium,
            'descricao' => "Compra do Passe Premium: {$passeAtivo->nome}"
        ]);

        // Desbloqueia o Premium
        $progresso->premium_desbloqueado = true;
        $progresso->save();

        // ENTREGAR RECOMPENSAS RETROATIVAS
        // Pega todos os níveis premium que o jogador JÁ passou e entrega os prêmios
        $niveisAtrasados = PasseNivel::where('passe_id', $passeAtivo->id)
            ->where('nivel', '<=', $progresso->nivel_atual)
            ->where('is_premium', true)
            ->get();

        $recompensasEntregues = 0;
        foreach ($niveisAtrasados as $nivel) {
            $this->entregarRecompensa($user, $nivel);
            $recompensasEntregues++;
        }

        $mensagem = 'Passe Premium Desbloqueado com sucesso!';
        if ($recompensasEntregues > 0) {
            $mensagem .= " Todas as {$recompensasEntregues} recompensas premium dos níveis que você já alcançou foram enviadas ao seu inventário.";
        }

        return redirect()->back()->with('sucesso', $mensagem);
    }

    

    
}