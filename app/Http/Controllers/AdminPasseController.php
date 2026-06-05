<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Passe;
use App\Models\PasseNivel;
use App\Models\Missao;
use App\Models\UserMissao;
use App\Models\UserPasse;
use App\Models\Transacao;
use App\Models\InventarioChibi;
use App\Models\User;

class AdminPasseController extends Controller
{
    // Exibe o painel de gerenciamento
    public function index()
    {
        // Traz todos os passes e já carrega os níveis e missões de cada um
        $passes = Passe::with(['niveis', 'missoes'])->orderBy('id', 'desc')->get();
        return view('admin.passes.index', compact('passes'));
    }

    // Cria uma nova Temporada (Passe)
    public function storePasse(Request $request)
    {
        Passe::create([
            'nome' => $request->nome,
            'data_inicio' => $request->data_inicio,
            'data_fim' => $request->data_fim,
            'ativo' => $request->has('ativo') // Checkbox de ativo
        ]);
        return redirect()->back()->with('sucesso', 'Nova temporada criada com sucesso!');
    }

    // Adiciona um nível a um passe específico
    public function storeNivel(Request $request, $passe_id)
    {
        PasseNivel::create([
            'passe_id' => $passe_id,
            'nivel' => $request->nivel,
            'xp_necessario' => $request->xp_necessario,
            'recompensa_tipo' => $request->recompensa_tipo,
            'recompensa_id' => $request->recompensa_id, // Pode ser null
            'quantidade' => $request->quantidade,
            'is_premium' => $request->has('is_premium')
        ]);
        return redirect()->back()->with('sucesso', 'Nível adicionado ao passe!');
    }

    // Adiciona uma missão a um passe
    public function storeMissao(Request $request, $passe_id)
    {
        Missao::create([
            'passe_id' => $passe_id,
            'titulo' => $request->titulo,
            'descricao' => $request->descricao,
            'tipo' => $request->tipo, // diaria, semanal, etc
            'xp_recompensa' => $request->xp_recompensa
        ]);
        return redirect()->back()->with('sucesso', 'Missão registrada!');
    }

    // --- SISTEMA DE VERIFICAÇÃO DE MISSÕES ---

    public function verificacoes(Request $request)
    {
        // Puxa apenas as missões com status pendente
        $query = UserMissao::with(['user', 'missao'])->where('status', 'pendente');

        // Filtro por usuário
        if ($request->has('user_id') && $request->user_id != '') {
            $query->where('user_id', $request->user_id);
        }

        $pendentes = $query->get();
        // Busca todos os usuários que têm pelo menos uma missão pendente para o filtro do select
        $usersFiltro = User::whereHas('userMissoes', function($q){ $q->where('status', 'pendente'); })->get();

        return view('admin.passes.verificacoes', compact('pendentes', 'usersFiltro'));
    }

    public function aprovarMissao($id)
    {
        $userMissao = UserMissao::findOrFail($id);
        $user = $userMissao->user;
        $missao = $userMissao->missao;
        
        // Altera o status para coletada (aprovada)
        $userMissao->status = 'coletada';
        $userMissao->save();

        $passeAtivo = Passe::where('ativo', true)->first();
        if($passeAtivo) {
            $progresso = UserPasse::firstOrCreate(
                ['user_id' => $user->id, 'passe_id' => $passeAtivo->id],
                ['xp_atual' => 0, 'nivel_atual' => 0, 'premium_desbloqueado' => false]
            );
            
            // Adiciona o XP ao jogador
            $progresso->xp_atual += $missao->xp_recompensa;
            $progresso->save();

            // Verifica Level Up
            $this->verificarLevelUp($user, $progresso, $passeAtivo);
        }

        return redirect()->back()->with('sucesso', 'Missão aprovada! O XP foi creditado ao jogador.');
    }

    public function recusarMissao($id)
    {
        // Deleta o registro para que o jogador possa tentar enviar novamente
        UserMissao::findOrFail($id)->delete();
        return redirect()->back()->with('sucesso', 'Missão recusada. O jogador poderá solicitar novamente.');
    }

    // --- LÓGICA DE LEVEL UP (Movida para o Admin) ---
    private function verificarLevelUp($user, $progresso, $passeAtivo)
    {
        $niveisPendentes = PasseNivel::where('passe_id', $passeAtivo->id)->where('nivel', '>', $progresso->nivel_atual)->orderBy('nivel', 'asc')->get();
        foreach ($niveisPendentes as $nivel) {
            if ($progresso->xp_atual >= $nivel->xp_necessario) {
                if ($nivel->is_premium && !$progresso->premium_desbloqueado) {
                    // Pula a entrega
                } else {
                    $this->entregarRecompensa($user, $nivel);
                }
                $progresso->nivel_atual = $nivel->nivel;
                $progresso->save();
            } else {
                break;
            }
        }
    }

    private function entregarRecompensa($user, $nivel)
    {
        switch (strtolower($nivel->recompensa_tipo)) {
            case 'moeda':
                Transacao::create(['user_id' => $user->id, 'tipo' => 'entrada', 'valor' => $nivel->quantidade, 'descricao' => "Passe Nível {$nivel->nivel}"]);
                break;
            case 'giro':
                $user->giros_chibi += $nivel->quantidade;
                $user->save();
                break;
            case 'chibi':
                if($nivel->recompensa_id) {
                    $inventario = InventarioChibi::where('user_id', $user->id)->where('chibi_id', $nivel->recompensa_id)->first();
                    if ($inventario) { $inventario->increment('quantidade', $nivel->quantidade); } 
                    else { InventarioChibi::create(['user_id' => $user->id, 'chibi_id' => $nivel->recompensa_id, 'quantidade' => $nivel->quantidade]); }
                }
                break;
        }
    }
}