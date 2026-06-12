<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl leading-tight header-title">
            {{ __('Simulador do Destino') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                
                <div class="rng-box flex flex-col justify-center items-center h-full">
                    <p class="text-gray-400 text-sm mb-4">A chance cai pela metade a cada número.<br>Até onde a sua sorte vai?</p>
                    
                    <div id="resultado" class="numero-display">1</div>
                    
                    <button id="btnGirar" onclick="girarRoleta()" class="btn-rng">
                        Tentar Sorte
                    </button>
                    
                    <div id="msgRecorde" class="msg-novo-recorde mt-6">
                        🎉 NOVO RECORDE PESSOAL! 🎉
                    </div>
                </div>

                <div class="leaderboard-box">
                    <div class="leaderboard-header">
                        🏆 Hall do Destino (Top 10)
                    </div>
                    <div class="p-4">
                        <table class="w-full text-left text-gray-300">
                            <thead>
                                <tr>
                                    <th class="p-2 text-gray-500 uppercase text-xs">Jogador</th>
                                    <th class="p-2 text-gray-500 uppercase text-xs text-right">Maior Número</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($recordes as $index => $recorde)
                                    <tr class="table-row">
                                        <td class="p-3 font-bold flex items-center gap-2">
                                            @if($index === 0) 👑 @elseif($index === 1) 🥈 @elseif($index === 2) 🥉 @else <span class="w-5 text-center text-gray-600 text-xs">{{ $index + 1 }}</span> @endif
                                            {{ $recorde->name }}
                                        </td>
                                        <td class="p-3 text-right {{ $index === 0 ? 'rank-gold' : 'font-bold text-indigo-400' }}">
                                            {{ $recorde->maior_numero_rng }}
                                        </td>
                                    </tr>
                                @empty
                                    <tr><td colspan="2" class="text-center p-4 text-gray-500 italic">Nenhum recorde registrado ainda.</td></tr>
                                @endforelse
                            </tbody>
                        </table>
                        <p class="text-center text-xs text-gray-500 mt-4">* Atualize a página para ver a tabela mais recente.</p>
                    </div>
                </div>

            </div>

        </div>
    </div>

    <script>
        function girarRoleta() {
            const btn = document.getElementById('btnGirar');
            const display = document.getElementById('resultado');
            const msgRecorde = document.getElementById('msgRecorde');
            
            // Trava o botão
            btn.disabled = true;
            btn.innerText = "Girando...";
            msgRecorde.style.display = 'none';
            display.classList.add('animando');
            
            // Faz a requisição para o Laravel
            fetch("{{ route('rng.girar') }}", {
                method: "POST",
                headers: {
                    "Content-Type": "application/json",
                    "X-CSRF-TOKEN": "{{ csrf_token() }}" // Token de segurança do Laravel
                }
            })
            .then(response => response.json())
            .then(data => {
                // Efeito visual simulando os números subindo
                let counter = 1;
                let interval = setInterval(() => {
                    display.innerText = counter;
                    if (counter >= data.numero) {
                        clearInterval(interval);
                        display.classList.remove('animando');
                        btn.disabled = false;
                        btn.innerText = "Tentar Sorte Novamente";
                        
                        if(data.novo_recorde) {
                            msgRecorde.style.display = 'block';
                        }
                    }
                    counter++;
                }, 100); // Velocidade da roleta (100ms por número)
            })
            .catch(error => {
                console.error("Erro:", error);
                btn.disabled = false;
                btn.innerText = "Erro. Tente Novamente.";
                display.classList.remove('animando');
            });
        }
    </script>
</x-app-layout>