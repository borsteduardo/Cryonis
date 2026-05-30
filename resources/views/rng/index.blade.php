<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl leading-tight header-title">
            {{ __('Simulador do Destino') }}
        </h2>
    </x-slot>

    <style>
        body, .min-h-screen, main, .bg-gray-100 { background-color: #030303 !important; }
        .header-title { color: #a855f7 !important; text-transform: uppercase; letter-spacing: 2px; text-shadow: 0 0 10px rgba(147, 51, 234, 0.5); font-weight: 900 !important; }

        /* Estilo da Caixa do Jogo */
        .rng-box {
            background-color: #09090b !important;
            border: 1px solid rgba(147, 51, 234, 0.4) !important;
            box-shadow: 0 0 20px rgba(147, 51, 234, 0.15) !important;
            position: relative;
            color: #e5e7eb !important;
            padding: 3rem;
            border-radius: 1rem;
            text-align: center;
        }
        .rng-box::before { content: ''; position: absolute; top: 0; left: 0; width: 100%; height: 3px; background: linear-gradient(90deg, #6d28d9, #db2777, #fca5a5); border-top-left-radius: 1rem; border-top-right-radius: 1rem; }

        .numero-display {
            font-size: 8rem;
            font-weight: 900;
            color: #d8b4fe;
            text-shadow: 0 0 30px rgba(168, 85, 247, 0.6);
            margin: 2rem 0;
            transition: all 0.2s ease;
        }

        .numero-display.animando {
            transform: scale(1.1);
            color: #fff;
            text-shadow: 0 0 50px rgba(255, 255, 255, 0.8);
        }

        /* Botão Girar */
        button.btn-rng {
            background: linear-gradient(90deg, #6d28d9, #db2777) !important;
            border: none !important;
            color: white !important;
            font-weight: 900 !important;
            font-size: 1.5rem !important;
            padding: 15px 40px !important;
            border-radius: 50px !important;
            transition: all 0.3s ease !important;
            box-shadow: 0 10px 20px rgba(219, 39, 119, 0.3) !important;
            text-transform: uppercase;
            letter-spacing: 2px;
        }
        button.btn-rng:hover { transform: scale(1.05) !important; box-shadow: 0 15px 30px rgba(219, 39, 119, 0.6) !important; }
        button.btn-rng:active { transform: scale(0.95) !important; }
        button.btn-rng:disabled { opacity: 0.5; cursor: not-allowed; transform: none !important; }

        /* Tabela Leaderboard */
        .leaderboard-box { background-color: rgba(147, 51, 234, 0.05) !important; border: 1px solid rgba(147, 51, 234, 0.3) !important; border-radius: 1rem; overflow: hidden; }
        .leaderboard-header { background: linear-gradient(135deg, #1a0b2e, #4c1d95) !important; color: #d8b4fe !important; padding: 1rem; text-align: center; font-weight: 900; text-transform: uppercase; letter-spacing: 1px; }
        .table-row { border-bottom: 1px solid rgba(147, 51, 234, 0.2); transition: background 0.2s; }
        .table-row:hover { background-color: rgba(147, 51, 234, 0.1); }
        .rank-gold { color: #fbbf24; text-shadow: 0 0 10px rgba(251, 191, 36, 0.5); font-weight: 900; font-size: 1.2rem; }
        
        .msg-novo-recorde { display: none; color: #10b981; font-weight: bold; margin-top: 10px; font-size: 1.2rem; text-transform: uppercase; letter-spacing: 1px; animation: piscar 1s infinite; }
        @keyframes piscar { 0%, 100% { opacity: 1; text-shadow: 0 0 10px rgba(16, 185, 129, 0.5); } 50% { opacity: 0.5; text-shadow: none; } }
    </style>

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