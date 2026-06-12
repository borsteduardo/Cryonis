<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl leading-tight text-transparent bg-clip-text bg-gradient-to-r from-purple-400 to-pink-600 uppercase font-black tracking-widest text-shadow-sm">
            {{ __('Passe de Batalha') }}
        </h2>
    </x-slot>

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