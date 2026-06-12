<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl leading-tight header-title">
            {{ __('Meu Inventário de Chibis') }}
        </h2>
    </x-slot>

    <style>
        body, .min-h-screen, main { background-color: #030303 !important; }
        .header-title { color: #a855f7 !important; text-transform: uppercase; letter-spacing: 2px; text-shadow: 0 0 10px rgba(147, 51, 234, 0.5); font-weight: 900 !important; }

        /* Textos das Raridades */
        .raridade-Comum { color: #9ca3af; text-shadow: 0 0 5px rgba(156, 163, 175, 0.5); }
        .raridade-Incomum { color: #10b981; text-shadow: 0 0 5px rgba(16, 185, 129, 0.5); }
        .raridade-Raro { color: #3b82f6; text-shadow: 0 0 5px rgba(59, 130, 246, 0.5); }
        .raridade-Épico { color: #8b5cf6; text-shadow: 0 0 5px rgba(139, 92, 246, 0.5); }
        .raridade-Lendário { color: #f59e0b; text-shadow: 0 0 5px rgba(245, 158, 11, 0.5); }
        .raridade-Mítico { color: #ef4444; text-shadow: 0 0 10px rgba(239, 68, 68, 0.8); font-weight: 900; }
        .raridade-Secreto { color: #f472b6; text-shadow: 0 0 15px rgba(244, 114, 182, 0.9); font-weight: 900; letter-spacing: 2px; }

        /* Bordas dos Cards baseadas na Raridade */
        .borda-Comum { border-top: 4px solid #9ca3af !important; }
        .borda-Incomum { border-top: 4px solid #10b981 !important; }
        .borda-Raro { border-top: 4px solid #3b82f6 !important; }
        .borda-Épico { border-top: 4px solid #8b5cf6 !important; }
        .borda-Lendário { border-top: 4px solid #f59e0b !important; }
        .borda-Mítico { border-top: 4px solid #ef4444 !important; box-shadow: 0 0 15px rgba(239, 68, 68, 0.2); }
        .borda-Secreto { border-top: 4px solid #f472b6 !important; box-shadow: 0 0 20px rgba(244, 114, 182, 0.3); }

        /* Cards do Inventário */
        .chibi-card { 
            background-color: #09090b; 
            border: 1px solid rgba(255, 255, 255, 0.1); 
            border-radius: 1rem; 
            position: relative; 
            color: #e5e7eb; 
            transition: transform 0.2s, box-shadow 0.2s; 
            overflow: hidden; 
            display: flex;
            flex-direction: column;
        }
        .chibi-card:hover { transform: translateY(-5px); z-index: 10; box-shadow: 0 10px 20px rgba(0,0,0,0.8); }
        
        /* Contador de Repetidos */
        .badge-quantidade { 
            position: absolute; 
            top: 15px; 
            right: 15px; 
            background: rgba(0,0,0,0.8); 
            border: 1px solid rgba(255,255,255,0.2); 
            border-radius: 50%; 
            width: 40px; 
            height: 40px; 
            display: flex; 
            align-items: center; 
            justify-content: center; 
            font-weight: 900; 
            font-size: 1.1rem; 
            box-shadow: 0 0 10px rgba(0,0,0,0.5); 
        }

        /* Botão Voltar */
        .btn-voltar { 
            display: inline-block; 
            background: transparent; 
            border: 1px solid #4c1d95; 
            color: #d8b4fe; 
            padding: 8px 16px; 
            border-radius: 0.5rem; 
            transition: 0.3s; 
            text-decoration: none; 
            font-weight: bold; 
            margin-bottom: 20px; 
        }
        .btn-voltar:hover { background: #4c1d95; color: white; box-shadow: 0 0 10px rgba(76, 29, 149, 0.5); }
    </style>

    <div class="py-12 max-w-7xl mx-auto sm:px-6 lg:px-8">
        
        <a href="{{ route('chibis.index') }}" class="btn-voltar">← Voltar para a Máquina</a>

        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
            @forelse($inventario as $item)
                <div class="chibi-card borda-{{ $item->chibi->raridade }}">
                    
                    <div class="badge-quantidade raridade-{{ $item->chibi->raridade }}">
                        {{ $item->quantidade }}x
                    </div>
                    
                    <div class="p-6 flex-grow flex flex-col">
                        <h3 class="font-black text-xl uppercase pr-8">{{ $item->chibi->nome }}</h3>
                        <p class="text-sm font-bold raridade-{{ $item->chibi->raridade }} mb-4 tracking-widest uppercase">{{ $item->chibi->raridade }}</p>
                        
                        <p class="text-gray-400 text-sm italic mb-4 flex-grow">"{{ $item->chibi->descricao }}"</p>
                        
                        @if($item->chibi->observacoes)
                            <div class="border-t border-gray-800 pt-3 mt-4">
                                <p class="text-xs text-gray-500"><strong class="text-gray-400">Obs:</strong> {{ $item->chibi->observacoes }}</p>
                            </div>
                        @endif
                    </div>
                </div>
            @empty
                <div class="col-span-full bg-[#09090b] border border-dashed border-[#4c1d95] rounded-xl p-10 text-center">
                    <p class="text-gray-400 text-lg mb-2">Seu inventário de Chibis está vazio.</p>
                    <p class="text-gray-500 text-sm">Volte para a tela anterior e gaste seus giros para começar sua coleção!</p>
                </div>
            @endforelse
        </div>

    </div>
</x-app-layout>