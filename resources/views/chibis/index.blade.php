<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl leading-tight header-title">
            {{ __('Banner de Chibis') }}
        </h2>
    </x-slot>

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