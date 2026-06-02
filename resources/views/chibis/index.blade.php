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
            resBox.style.display = 'none'; // Esconde resultado anterior

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
                    window.location.reload(); // Recarrega se der erro de giros
                    return;
                }

                // Simula um delay de suspense antes de mostrar a carta
                setTimeout(() => {
                    const ch = data.chibi;
                    
                    document.getElementById('res-nome').innerText = ch.nome;
                    document.getElementById('res-desc').innerText = '"' + ch.descricao + '"';
                    
                    const raridadeEl = document.getElementById('res-raridade');
                    raridadeEl.innerText = ch.raridade;
                    // Limpa classes de cor antigas e coloca a nova
                    raridadeEl.className = 'text-xl tracking-widest uppercase mb-1 raridade-' + ch.raridade;

                    resBox.style.display = 'block';
                    btn.innerText = "Girar Novamente";
                    
                    // Se a pessoa tiver mais giros, libera o botão. Se não, avisa.
                    let girosAtuais = parseInt(document.querySelector('strong.text-white').innerText);
                    document.querySelector('strong.text-white').innerText = girosAtuais - 1;
                    
                    if (girosAtuais - 1 > 0) {
                        btn.disabled = false;
                    } else {
                        btn.innerText = "Sem Giros";
                    }

                }, 1500); // 1.5 segundos de "suspense"
            })
            .catch(error => {
                console.error("Erro:", error);
                alert("Ocorreu um erro no sorteio.");
                window.location.reload();
            });
        }
    </script>
</x-app-layout>