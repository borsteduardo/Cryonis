<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl leading-tight text-transparent bg-clip-text bg-gradient-to-r from-purple-400 to-pink-600 uppercase font-black tracking-widest text-shadow-sm">
            {{ __('Passe de Batalha') }}
        </h2>
    </x-slot>

    <style>
        body, .min-h-screen, main { background-color: #030303 !important; }
        .dark-box { background-color: #09090b; border: 1px solid rgba(147, 51, 234, 0.4); box-shadow: 0 0 20px rgba(147, 51, 234, 0.15); border-radius: 1rem; padding: 1.5rem; color: #e5e7eb; position: relative; overflow: hidden; }
        
        /* Nova Timeline estilo Valorant/Apex */
        .timeline-wrapper { position: relative; padding: 8rem 1rem; overflow-x: auto; white-space: nowrap; scrollbar-width: thin; scrollbar-color: #9333ea #111827; }
        .timeline-line-bg { position: absolute; top: 50%; left: 0; right: 0; height: 6px; background-color: #1f2937; transform: translateY(-50%); z-index: 1; border-radius: 10px; }
        .timeline-line-fill { position: absolute; top: 0; left: 0; height: 100%; background: linear-gradient(90deg, #6d28d9, #db2777); border-radius: 10px; transition: 0.5s; box-shadow: 0 0 10px rgba(219,39,119,0.5); }
        .timeline-nodes { display: inline-flex; align-items: center; gap: 5rem; position: relative; z-index: 2; padding: 0 2rem; }
        
        .node-container { display: flex; flex-direction: column; align-items: center; justify-content: center; position: relative; }
        .node-circle { width: 3.5rem; height: 3.5rem; border-radius: 50%; background-color: #111827; border: 4px solid #374151; display: flex; align-items: center; justify-content: center; font-weight: 900; font-size: 1.2rem; transition: 0.3s; z-index: 3; }
        .node-container.desbloqueado .node-circle { border-color: #10b981; color: #10b981; box-shadow: 0 0 15px rgba(16,185,129,0.4); }
        .node-container.atual .node-circle { border-color: #db2777; color: #db2777; box-shadow: 0 0 20px rgba(219,39,119,0.8); transform: scale(1.1); }
        
        /* Caixas de Recompensa (Top = Free, Bottom = Premium) */
        .reward-box { position: absolute; width: 110px; text-align: center; padding: 0.5rem; border-radius: 0.5rem; background: #000; border: 1px solid #374151; opacity: 0.8; transition: 0.3s; white-space: normal; }
        .reward-free { bottom: 100%; margin-bottom: 2rem; }
        .reward-premium { top: 100%; margin-top: 2rem; border-color: #831843; background: #1a0812; }
        .reward-free::after, .reward-premium::before { content: ''; position: absolute; width: 2px; height: 1.5rem; background: #374151; left: 50%; transform: translateX(-50%); z-index: -1; }
        .reward-free::after { top: 100%; }
        .reward-premium::before { bottom: 100%; background: #831843; }
        
        .node-container.desbloqueado .reward-box { opacity: 1; border-color: #10b981; }
        .node-container.desbloqueado .reward-premium { border-color: #db2777; }
        .reward-icon { font-size: 1.5rem; margin-bottom: 0.2rem; }

        /* Missões */
        .missao-card { background-color: #111827; border: 1px solid #374151; border-radius: 0.5rem; padding: 1rem; margin-bottom: 0.5rem; display: flex; justify-content: space-between; align-items: center; border-left: 4px solid #4c1d95; }
        .badge-pendente { background: rgba(245, 158, 11, 0.2); color: #fbbf24; border: 1px solid #f59e0b; padding: 5px 10px; border-radius: 5px; font-size: 0.75rem; font-weight: bold; text-transform: uppercase; }
        .badge-aprovada { background: rgba(16, 185, 129, 0.2); color: #10b981; border: 1px solid #10b981; padding: 5px 10px; border-radius: 5px; font-size: 0.75rem; font-weight: bold; text-transform: uppercase; opacity: 0.7; }
    </style>

    <div class="py-12 max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">

        @if (session('sucesso')) <div class="bg-green-900 border border-green-500 text-green-200 px-4 py-3 rounded">{{ session('sucesso') }}</div> @endif
        @if (session('erro')) <div class="bg-red-900 border border-red-500 text-red-200 px-4 py-3 rounded">{{ session('erro') }}</div> @endif

        @if(!$passeAtivo)
            <div class="dark-box text-center py-16"><h2 class="text-3xl font-black text-gray-500">Nenhuma temporada ativa</h2></div>
        @else
            <!-- CABEÇALHO BÁSICO -->
            <div class="dark-box flex justify-between items-center !py-6">
                <div>
                    <h2 class="text-2xl font-black text-white uppercase">{{ $passeAtivo->nome }}</h2>
                    <p class="text-sm text-pink-500 font-bold uppercase mt-1">XP Atual: {{ number_format($progresso->xp_atual, 0, ',', '.') }}</p>
                </div>
                
                @if(!$progresso->premium_desbloqueado)
                    <form action="{{ route('passe.comprarPremium') }}" method="POST" onsubmit="return confirm('Comprar o Passe Premium por 100.000 Coins? Prêmios passados virão na hora!');">
                        @csrf <button type="submit" class="bg-pink-600 hover:bg-pink-500 text-white font-bold py-2 px-6 rounded text-sm shadow-[0_0_15px_rgba(219,39,119,0.5)]">🔓 Desbloquear Premium</button>
                    </form>
                @else
                    <span class="bg-indigo-900 text-indigo-300 py-2 px-6 rounded text-sm font-bold border border-indigo-500 uppercase shadow-[0_0_10px_rgba(99,102,241,0.5)]">👑 Premium Ativo</span>
                @endif
            </div>

            <!-- A NOVA TIMELINE -->
            <div class="dark-box">
                <div class="mb-2 border-b border-gray-800 pb-2"><h3 class="text-xl font-bold text-gray-300 uppercase tracking-widest">Trilha de Progresso</h3></div>
                
                <div class="timeline-wrapper">
                    @php
                        // Agrupa as recompensas por número de nível para desenhar o círculo uma vez só
                        $niveisAgrupados = $passeAtivo->niveis->groupBy('nivel')->sortKeys();
                        $xpMaximo = $passeAtivo->niveis->max('xp_necessario') ?? 1;
                        $porcentagemPasse = min(100, ($progresso->xp_atual / $xpMaximo) * 100);
                    @endphp

                    <div class="timeline-line-bg">
                        <div class="timeline-line-fill" style="width: {{ $porcentagemPasse }}%;"></div>
                    </div>

                    <div class="timeline-nodes">
                        @foreach($niveisAgrupados as $numNivel => $recompensas)
                            @php
                                $reqXp = $recompensas->first()->xp_necessario;
                                $statusLevel = '';
                                if ($progresso->nivel_atual >= $numNivel) { $statusLevel = 'desbloqueado'; }
                                // Destaca o próximo nível imediato
                                if ($progresso->nivel_atual == $numNivel - 1) { $statusLevel = 'atual'; }

                                $free = $recompensas->where('is_premium', false)->first();
                                $premium = $recompensas->where('is_premium', true)->first();
                            @endphp

                            <div class="node-container {{ $statusLevel }}">
                                
                                <!-- Recompensa Grátis (Topo) -->
                                @if($free)
                                    <div class="reward-box reward-free">
                                        <div class="reward-icon">{{ $free->recompensa_tipo == 'moeda' ? '💰' : ($free->recompensa_tipo == 'giro' ? '🎰' : '🎁') }}</div>
                                        <p class="text-[0.65rem] text-gray-300 font-bold uppercase leading-tight">{{ $free->quantidade }}x {{ $free->recompensa_tipo }}</p>
                                    </div>
                                @endif

                                <!-- O Círculo do Nível -->
                                <div class="node-circle" title="Necessário: {{ $reqXp }} XP">{{ $numNivel }}</div>
                                <span class="absolute top-[110%] mt-1 text-[0.6rem] text-gray-500 font-black">{{ $reqXp }} XP</span>

                                <!-- Recompensa Premium (Fundo) -->
                                @if($premium)
                                    <div class="reward-box reward-premium">
                                        <div class="reward-icon">{{ $premium->recompensa_tipo == 'moeda' ? '💰' : ($premium->recompensa_tipo == 'giro' ? '🎰' : '🎁') }}</div>
                                        <p class="text-[0.65rem] text-pink-400 font-bold uppercase leading-tight">{{ $premium->quantidade }}x {{ $premium->recompensa_tipo }}</p>
                                    </div>
                                @endif

                            </div>
                        @endforeach
                    </div>
                </div>
            </div>

            <!-- PAINEL DE MISSÕES COM STATUS -->
            <div class="dark-box mt-6">
                <h3 class="text-xl font-bold text-gray-300 uppercase tracking-widest mb-4 border-b border-gray-800 pb-2">Tarefas Diárias e Semanais</h3>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    @foreach($passeAtivo->missoes as $missao)
                        @php $statusAtual = $statusMissoes[$missao->id] ?? null; @endphp

                        <div class="missao-card {{ $statusAtual == 'coletada' ? 'filter grayscale opacity-50' : '' }}">
                            <div>
                                <div class="flex items-center gap-2 mb-1">
                                    <span class="text-[0.65rem] font-bold px-2 py-1 rounded bg-indigo-900 text-indigo-300 uppercase">{{ $missao->tipo }}</span>
                                    <span class="text-yellow-500 font-black text-xs">+{{ $missao->xp_recompensa }} XP</span>
                                </div>
                                <h4 class="font-bold text-white text-sm">{{ $missao->titulo }}</h4>
                            </div>
                            
                            <div class="flex-shrink-0 ml-4">
                                @if($statusAtual === 'coletada')
                                    <span class="badge-aprovada">Concluída</span>
                                @elseif($statusAtual === 'pendente')
                                    <span class="badge-pendente">Em Análise</span>
                                @else
                                    <form action="{{ route('passe.missao.solicitar', $missao->id) }}" method="POST">
                                        @csrf <button type="submit" class="bg-gradient-to-r from-purple-600 to-pink-600 hover:from-purple-500 hover:to-pink-500 text-white px-3 py-2 rounded text-xs font-bold uppercase transition shadow-md">Concluir</button>
                                    </form>
                                @endif
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        @endif
    </div>
</x-app-layout>