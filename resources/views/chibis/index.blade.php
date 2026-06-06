<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl leading-tight header-title">
            {{ __('Banner de Chibis') }}
        </h2>
    </x-slot>

    <style>
        body, .min-h-screen, main { background-color: #030303 !important; }
        .header-title { color: #a855f7 !important; text-transform: uppercase; letter-spacing: 2px; text-shadow: 0 0 10px rgba(147, 51, 234, 0.5); font-weight: 900 !important; }

        /* Cores das Raridades */
        .raridade-Comum { color: #9ca3af; text-shadow: 0 0 5px rgba(156, 163, 175, 0.5); }
        .raridade-Incomum { color: #10b981; text-shadow: 0 0 5px rgba(16, 185, 129, 0.5); }
        .raridade-Raro { color: #3b82f6; text-shadow: 0 0 5px rgba(59, 130, 246, 0.5); }
        .raridade-Épico { color: #8b5cf6; text-shadow: 0 0 5px rgba(139, 92, 246, 0.5); }
        .raridade-Lendário { color: #f59e0b; text-shadow: 0 0 5px rgba(245, 158, 11, 0.5); }
        .raridade-Mítico { color: #ef4444; text-shadow: 0 0 10px rgba(239, 68, 68, 0.8); font-weight: 900; }
        .raridade-Secreto { color: #f472b6; text-shadow: 0 0 15px rgba(244, 114, 182, 0.9); font-weight: 900; letter-spacing: 2px; }

        /* Caixas Base */
        .dark-box { background-color: #09090b; border: 1px solid rgba(147, 51, 234, 0.4); box-shadow: 0 0 20px rgba(147, 51, 234, 0.15); border-radius: 1rem; padding: 2rem; color: #e5e7eb; position: relative; }
        .dark-box::before { content: ''; position: absolute; top: 0; left: 0; width: 100%; height: 3px; background: linear-gradient(90deg, #6d28d9, #db2777); border-top-left-radius: 1rem; border-top-right-radius: 1rem; }

        /* Botões */
        .btn-comprar { background: linear-gradient(90deg, #059669, #10b981); color: white; font-weight: bold; padding: 10px 20px; border-radius: 0.5rem; transition: 0.3s; }
        .btn-comprar:hover { box-shadow: 0 0 15px rgba(16, 185, 129, 0.6); transform: scale(1.05); }
        .btn-girar { background: linear-gradient(90deg, #6d28d9, #db2777); color: white; font-weight: 900; font-size: 1.5rem; padding: 15px 40px; border-radius: 50px; transition: 0.3s; border: none; cursor: pointer; text-transform: uppercase; }
        .btn-girar:hover:not(:disabled) { box-shadow: 0 0 20px rgba(219, 39, 119, 0.8); transform: scale(1.05); }
        .btn-girar:disabled { opacity: 0.5; cursor: not-allowed; }

        /* Área do Sorteio Animado */
        #gacha-resultado { display: none; margin-top: 2rem; padding: 2rem; border-radius: 1rem; background: #000; border: 2px solid #333; text-align: center; animation: brilho 2s infinite alternate; }
        @keyframes brilho { from { box-shadow: 0 0 10px #333; } to { box-shadow: 0 0 30px #db2777; } }
        .chibi-sorteado-nome { font-size: 2.5rem; font-weight: 900; text-transform: uppercase; margin-bottom: 0.5rem; }
    </style>

    <div class="py-12 max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-8">

        @if (session('sucesso'))
            <div class="bg-green-900 border border-green-500 text-green-200 px-4 py-3 rounded relative shadow-sm">
                {{ session('sucesso') }}
            </div>
        @endif
        @if (session('erro'))
            <div class="bg-red-900 border border-red-500 text-red-200 px-4 py-3 rounded relative shadow-sm">
                {{ session('erro') }}
            </div>
        @endif

        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            
            <div class="dark-box flex flex-col justify-between">
                <div>
                    <h3 class="text-xl font-bold text-indigo-400 mb-4">Seus Status</h3>
                    <p class="text-gray-300 text-lg mb-2">Giros Disponíveis: <strong class="text-white text-2xl">{{ $user->giros_chibi }}</strong></p>
                    <p class="text-gray-400 text-sm">Limite Semanal: {{ $user->compras_giro_semana }} / 10</p>
                </div>
                
                <div class="mt-6 pt-6 border-t border-gray-800">
                    <p class="text-xs text-gray-500 mb-2">1 Giro = 25.000 Coins</p>
                    <form action="{{ route('chibis.comprar') }}" method="POST">
                        @csrf
                        <button type="submit" class="btn-comprar w-full">Comprar 1 Giro</button>
                    </form>
                    <a href="{{ route('chibis.inventario') }}" class="mt-4 block text-center text-indigo-400 hover:text-indigo-300 underline font-bold">Ver Meu Inventário</a>
                </div>
            </div>

            <div class="dark-box md:col-span-2 text-center flex flex-col items-center justify-center min-h-[300px]">
                <h2 class="text-3xl font-black text-transparent bg-clip-text bg-gradient-to-r from-purple-400 to-pink-600 mb-6">
                    MÁQUINA DO DESTINO
                </h2>
                
                <button id="btnGirar" onclick="rolarGacha()" class="btn-girar" {{ $user->giros_chibi <= 0 ? 'disabled' : '' }}>
                    Puxar Chibi
                </button>

                <form action="{{ route('chibis.girar10x') }}" method="POST" class="inline-block mt-4">
                    @csrf
                    <button type="submit" class="bg-gradient-to-r from-purple-600 to-indigo-600 hover:from-purple-500 hover:to-indigo-500 text-white font-black py-3 px-8 rounded-xl shadow-[0_0_15px_rgba(79,70,229,0.5)] transition transform hover:scale-105 border border-indigo-400">
                        🎰 GIRAR 10x
                    </button>
                </form>

                <div id="gacha-resultado" class="w-full max-w-md mx-auto">
                    <p class="text-gray-400 text-sm mb-2">Você conseguiu um...</p>
                    <h3 id="res-raridade" class="text-xl tracking-widest uppercase mb-1">Raridade</h3>
                    <h2 id="res-nome" class="chibi-sorteado-nome text-white">NOME DO CHIBI</h2>
                    <p id="res-desc" class="text-gray-300 italic text-sm mt-4">Descrição</p>
                </div>
            </div>
        </div>

        @if(Auth::user()->patente === 'Ficheiro' || Auth::user()->patente === 'Conselheiro')
        <div class="dark-box">
            <h3 class="text-xl font-bold text-red-400 mb-4">⚙️ Painel da Staff: Cadastrar Chibi</h3>
            <form action="{{ route('chibis.store') }}" method="POST" class="grid grid-cols-1 md:grid-cols-2 gap-4">
                @csrf
                <div>
                    <label class="block text-sm font-medium text-gray-400">Nome do Chibi</label>
                    <input type="text" name="nome" required class="w-full bg-black border-gray-700 rounded text-white mt-1">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-400">Raridade</label>
                    <select name="raridade" required class="w-full bg-black border-gray-700 rounded text-white mt-1">
                        <option value="Comum">Comum (50%)</option>
                        <option value="Incomum">Incomum (30%)</option>
                        <option value="Raro">Raro (12%)</option>
                        <option value="Épico">Épico (5.5%)</option>
                        <option value="Lendário">Lendário (2%)</option>
                        <option value="Mítico">Mítico (0.4%)</option>
                        <option value="Secreto">Secreto (0.1%)</option>
                    </select>
                </div>
                <div class="md:col-span-2">
                    <label class="block text-sm font-medium text-gray-400">Descrição</label>
                    <textarea name="descricao" required rows="2" class="w-full bg-black border-gray-700 rounded text-white mt-1"></textarea>
                </div>
                <div class="md:col-span-2">
                    <label class="block text-sm font-medium text-gray-400">Observações (Opcional)</label>
                    <textarea name="observacoes" rows="2" class="w-full bg-black border-gray-700 rounded text-white mt-1"></textarea>
                </div>
                <div class="md:col-span-2">
                    <button type="submit" class="bg-red-600 hover:bg-red-700 text-white font-bold py-2 px-4 rounded w-full">Adicionar Chibi ao Pool</button>
                </div>
            </form>
        </div>
        @endif

        <div class="dark-box">
            <h3 class="text-xl font-bold text-indigo-400 mb-4">Pool de Chibis Disponíveis</h3>
            <div class="overflow-x-auto">
                <table class="w-full text-left text-sm text-gray-300">
                    <thead class="bg-gray-900 text-gray-400 uppercase">
                        <tr>
                            <th class="p-3">Nome</th>
                            <th class="p-3">Raridade</th>
                            @if(Auth::user()->patente === 'Ficheiro' || Auth::user()->patente === 'Conselheiro')
                                <th class="p-3 text-right">Ação</th>
                            @endif
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($chibis as $chibi)
                            <tr class="border-b border-gray-800 hover:bg-gray-800/50 transition">
                                <td class="p-3 font-bold text-white">{{ $chibi->nome }}</td>
                                <td class="p-3 font-bold raridade-{{ $chibi->raridade }}">{{ $chibi->raridade }}</td>
                                
                                @if(Auth::user()->patente === 'Ficheiro' || Auth::user()->patente === 'Conselheiro')
                                <td class="p-3 text-right">
                                    <form action="{{ route('chibis.destroy', $chibi->id) }}" method="POST" onsubmit="return confirm('Excluir este Chibi?');">
                                        @csrf @method('DELETE')
                                        <button type="submit" class="text-red-500 hover:text-red-400 font-bold">X</button>
                                    </form>
                                </td>
                                @endif
                            </tr>
                        @empty
                            <tr><td colspan="3" class="p-4 text-center italic text-gray-500">Nenhum chibi cadastrado pela staff ainda.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

    </div>

    <script>
        function rolarGacha() {
            const btn = document.getElementById('btnGirar');
            const resBox = document.getElementById('gacha-resultado');
            
            btn.disabled = true;
            btn.innerText = "Sorteando...";
            resBox.style.display = 'none';

            fetch("{{ route('chibis.girar') }}", {
                method: "POST",
                headers: {
                    "Content-Type": "application/json",
                    "X-CSRF-TOKEN": "{{ csrf_token() }}"
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.erro) {
                    alert(data.erro);
                    window.location.reload(); 
                    return;
                }

                setTimeout(() => {
                    const ch = data.chibi;
                    
                    document.getElementById('res-nome').innerText = ch.nome;
                    document.getElementById('res-desc').innerText = '"' + ch.descricao + '"';
                    
                    const raridadeEl = document.getElementById('res-raridade');
                    raridadeEl.innerText = ch.raridade;
                    raridadeEl.className = 'text-xl tracking-widest uppercase mb-1 raridade-' + ch.raridade;

                    resBox.style.display = 'block';
                    btn.innerText = "Girar Novamente";
                    
                    let girosAtuais = parseInt(document.querySelector('strong.text-white').innerText);
                    document.querySelector('strong.text-white').innerText = girosAtuais - 1;
                    
                    if (girosAtuais - 1 > 0) {
                        btn.disabled = false;
                    } else {
                        btn.innerText = "Sem Giros";
                    }

                }, 1500);
            })
            .catch(error => {
                console.error("Erro:", error);
                alert("Ocorreu um erro no sorteio.");
                window.location.reload();
            });
        }
    </script>
        
    @if(session('chibisSorteados10x'))
        
        <style>
            /* Tema da Invocação: Nebulosa Azul/Branca Cintilante */
            .bg-nebula {
                background: radial-gradient(circle at 50% 50%, #1e3a8a 0%, #030303 80%);
                position: relative;
            }
            .bg-nebula::before {
                content: '';
                position: absolute;
                inset: 0;
                background-image: radial-gradient(white 1px, transparent 1px);
                background-size: 50px 50px;
                opacity: 0.15;
                animation: starTwinkle 3s infinite alternate;
            }

            @keyframes starTwinkle {
                0% { opacity: 0.05; transform: scale(1); }
                100% { opacity: 0.25; transform: scale(1.05); }
            }

            /* Fundos das Cartas por Raridade */
            .bg-card-Comum { background: linear-gradient(135deg, #374151, #111827); border-color: #9ca3af; }
            .bg-card-Incomum { background: linear-gradient(135deg, #047857, #064e3b); border-color: #34d399; }
            .bg-card-Raro { background: linear-gradient(135deg, #1d4ed8, #1e3a8a); border-color: #60a5fa; }
            .bg-card-Épico { background: linear-gradient(135deg, #6d28d9, #4c1d95); border-color: #a78bfa; }
            
            .bg-card-Lendário { 
                background: linear-gradient(135deg, #b45309, #78350f); 
                border-color: #fbbf24; 
                box-shadow: 0 0 15px rgba(251,191,36,0.5); 
            }
            .bg-card-Mítico { 
                background: linear-gradient(135deg, #b91c1c, #7f1d1d); 
                border-color: #f87171; 
                box-shadow: 0 0 25px rgba(239,68,68,0.7); 
            }
            .bg-card-Secreto { 
                background: radial-gradient(circle at top right, #ffffff, transparent 60%), linear-gradient(135deg, #0ea5e9, #0f172a); 
                border-color: #ffffff; 
                box-shadow: 0 0 35px rgba(255,255,255,0.9); 
            }

            /* Animação das cartas surgindo */
            @keyframes popInGacha {
                0% { opacity: 0; transform: scale(0.5) translateY(50px) rotate(-10deg); filter: brightness(2); }
                60% { transform: scale(1.1) translateY(-10px) rotate(3deg); filter: brightness(1.5); }
                100% { opacity: 1; transform: scale(1) translateY(0) rotate(0); filter: brightness(1); }
            }
            .animate-pop-in-gacha {
                animation: popInGacha 0.6s cubic-bezier(0.175, 0.885, 0.32, 1.275) forwards;
            }
            
            /* Brilho varrendo a carta (Reflexo de luz) */
            .shine-effect {
                position: absolute; top: 0; left: -100%; width: 50%; height: 100%;
                background: linear-gradient(to right, rgba(255,255,255,0) 0%, rgba(255,255,255,0.3) 50%, rgba(255,255,255,0) 100%);
                transform: skewX(-20deg); animation: shineSwipe 3s infinite;
            }
            @keyframes shineSwipe {
                0% { left: -100%; } 20% { left: 200%; } 100% { left: 200%; }
            }
        </style>

        <div id="telaAnimacao10x" class="fixed inset-0 z-[60] flex flex-col items-center justify-center bg-nebula overflow-hidden">
            
            <div class="relative w-40 h-40 mb-8 flex justify-center items-center">
                <div class="absolute inset-0 border-t-4 border-b-4 border-blue-400 rounded-full animate-spin shadow-[0_0_20px_rgba(96,165,250,0.6)]"></div>
                <div class="absolute inset-4 border-l-4 border-r-4 border-white rounded-full animate-spin shadow-[0_0_20px_rgba(255,255,255,0.8)]" style="animation-direction: reverse; animation-duration: 1.2s;"></div>
                
                <div class="absolute inset-0 flex items-center justify-center text-6xl animate-pulse drop-shadow-[0_0_15px_rgba(255,255,255,0.8)]">✨</div>
            </div>

            <h2 class="text-3xl font-black text-transparent bg-clip-text bg-gradient-to-r from-blue-300 to-white uppercase tracking-widest animate-pulse drop-shadow-[0_0_10px_rgba(255,255,255,0.5)]">
                Canalizando Energia...
            </h2>
        </div>

        <div class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-90 backdrop-blur-md px-4 hidden" id="modalResultados10x">
            <div class="bg-[#09090b] border border-blue-500 rounded-3xl shadow-[0_0_60px_rgba(59,130,246,0.3)] p-6 md:p-10 max-w-6xl w-full text-center relative max-h-[90vh] overflow-y-auto custom-scrollbar">
                
                <h2 class="text-4xl md:text-5xl font-black text-transparent bg-clip-text bg-gradient-to-r from-blue-400 to-pink-500 uppercase tracking-widest mb-2 drop-shadow-md">
                    Invocação Concluída!
                </h2>
                <p class="text-gray-400 mb-10 font-bold uppercase tracking-widest text-sm">Estes são os seus 10 novos Chibis</p>

                <div class="grid grid-cols-2 md:grid-cols-5 gap-4 md:gap-6 mb-10">
                    @foreach(session('chibisSorteados10x') as $index => $chibi)
                        <div class="chibi-card-10x bg-card-{{ $chibi['raridade'] }} border-2 rounded-xl p-5 flex flex-col items-center justify-center relative overflow-hidden opacity-0" 
                             style="animation-delay: {{ $index * 0.15 }}s;">
                            
                            <div class="absolute inset-0 bg-black opacity-40 mix-blend-overlay pointer-events-none"></div>
                            
                            @if(in_array($chibi['raridade'], ['Lendário', 'Mítico', 'Secreto']))
                                <div class="shine-effect"></div>
                            @endif

                            <span class="text-[0.65rem] uppercase font-black text-white bg-black/60 px-3 py-1 rounded-full mb-4 z-10 border border-white/20 backdrop-blur-sm shadow-md">
                                {{ $chibi['raridade'] }}
                            </span>
                            
                            <h3 class="text-lg font-black text-white z-10 uppercase leading-tight drop-shadow-[0_2px_4px_rgba(0,0,0,0.8)]">
                                {{ $chibi['nome'] }}
                            </h3>
                            
                        </div>
                    @endforeach
                </div>

                <button onclick="fecharModal10x()" class="bg-gradient-to-r from-blue-600 to-indigo-600 hover:from-blue-500 hover:to-indigo-500 text-white font-black py-4 px-12 rounded-xl transition shadow-[0_0_20px_rgba(59,130,246,0.5)] transform hover:scale-105 border border-blue-400 uppercase tracking-widest text-lg">
                    Adicionar à Coleção
                </button>
            </div>
        </div>

        <script>
            document.addEventListener('DOMContentLoaded', function() {
                // Suspense rola por 3 segundos agora para dar tempo de curtir a "Nebulosa"
                setTimeout(() => {
                    document.getElementById('telaAnimacao10x').style.display = 'none';
                    
                    const modal = document.getElementById('modalResultados10x');
                    modal.classList.remove('hidden');

                    const cards = document.querySelectorAll('.chibi-card-10x');
                    cards.forEach(card => {
                        card.classList.add('animate-pop-in-gacha');
                    });
                }, 3000); 
            });

            function fecharModal10x() {
                document.getElementById('modalResultados10x').style.display = 'none';
            }
        </script>
    @endif
</x-app-layout>