<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl leading-tight header-title">
            {{ __('Biblioteca de Cartas e Fichas') }}
        </h2>
    </x-slot>

    <style>
        body, .min-h-screen, main, .bg-gray-100 { background-color: #030303 !important; }
        .header-title { color: #a855f7 !important; text-transform: uppercase; letter-spacing: 2px; text-shadow: 0 0 10px rgba(147, 51, 234, 0.5); font-weight: 900 !important; }

        /* ================= PAINEL DE FILTROS ================= */
        .bg-white { background-color: #09090b !important; border: 1px solid rgba(147, 51, 234, 0.4) !important; box-shadow: 0 0 20px rgba(147, 51, 234, 0.15) !important; position: relative; color: #e5e7eb !important; }
        .bg-white::before { content: ''; position: absolute; top: 0; left: 0; width: 100%; height: 3px; background: linear-gradient(90deg, #6d28d9, #db2777, #fca5a5); border-top-left-radius: 10px; border-top-right-radius: 10px; }
        
        label.text-gray-700 { color: #d8b4fe !important; font-weight: bold !important; }
        input[type="text"], input[type="number"], select { background-color: #030303 !important; border: 1px solid #4c1d95 !important; color: #ffffff !important; border-radius: 6px !important; }
        input:focus, select:focus { border-color: #8b5cf6 !important; box-shadow: 0 0 10px rgba(139, 92, 246, 0.3) !important; outline: none !important; }
        select option { background-color: #09090b !important; color: #fff !important; }

        /* Botões de Ação Admin */
        a.bg-blue-600 { background: linear-gradient(90deg, #1d4ed8, #3b82f6) !important; border: none !important; transition: all 0.3s !important; }
        a.bg-green-600 { background: linear-gradient(90deg, #10b981, #059669) !important; border: none !important; transition: all 0.3s !important; }
        a.bg-purple-600 { background: linear-gradient(90deg, #6d28d9, #db2777) !important; border: none !important; transition: all 0.3s !important; }
        a.bg-blue-600:hover, a.bg-green-600:hover, a.bg-purple-600:hover { opacity: 0.9 !important; transform: scale(1.02) !important; box-shadow: 0 0 15px rgba(147, 51, 234, 0.5) !important; }

        button.bg-indigo-600 { background: rgba(147, 51, 234, 0.2) !important; color: #d8b4fe !important; border: 1px solid #9333ea !important; font-weight: bold !important; transition: all 0.3s !important; }
        button.bg-indigo-600:hover { background-color: #9333ea !important; color: #fff !important; box-shadow: 0 0 10px rgba(147, 51, 234, 0.5) !important; }

        /* ================= DESIGN DA CARTA (Igual ao Inventário) ================= */
        .rounded-xl:hover { transform: translateY(-5px) scale(1.02) !important; box-shadow: 0 10px 25px rgba(0, 0, 0, 0.6), 0 0 15px rgba(147, 51, 234, 0.4) !important; border-color: #a855f7 !important; z-index: 10; }
        
        .bg-gray-800 { background-color: rgba(147, 51, 234, 0.1) !important; border-bottom: 1px solid rgba(147, 51, 234, 0.3) !important; }
        .bg-gray-800 h3 { color: #d8b4fe !important; }
        .bg-indigo-500 { background-color: #9333ea !important; box-shadow: 0 0 8px rgba(147, 51, 234, 0.4) !important; border: 1px solid rgba(255,255,255,0.2) !important; }

        .text-gray-700 { color: #e5e7eb !important; }
        .border-gray-300 { border-color: #8b5cf6 !important; }
        .text-gray-600 { color: #a1a1aa !important; }

        .bg-gray-50 { background-color: rgba(0,0,0,0.3) !important; border: 1px solid rgba(147, 51, 234, 0.2) !important; }
        strong { color: #d8b4fe !important; }
        h4.text-gray-900 { color: #d8b4fe !important; border-color: rgba(147, 51, 234, 0.2) !important; }
        .text-red-600 { color: #f87171 !important; font-weight: bold !important; }
        
        /* Rodapé de Compra */
        .bg-gray-100 { background-color: #030303 !important; border-top: 1px solid rgba(147, 51, 234, 0.3) !important; border-bottom-left-radius: 10px; border-bottom-right-radius: 10px; }
        span.text-gray-500 { color: #a1a1aa !important; }
        span.text-emerald-600 { color: #fbbf24 !important; text-shadow: 0 0 10px rgba(251, 191, 36, 0.3) !important; font-weight: 900 !important; } /* Preço Dourado */
        
        /* Botão "Solicitar Compra" */
        form button.bg-indigo-600 { background: linear-gradient(90deg, #6d28d9, #db2777) !important; color: white !important; border: none !important; font-weight: bold !important; }
        form button.bg-indigo-600:hover { opacity: 0.9 !important; box-shadow: 0 0 10px rgba(219, 39, 119, 0.5) !important; }

        /* Estado Vazio */
        .col-span-full.bg-white { background-color: #09090b !important; border: 1px dashed rgba(147, 51, 234, 0.4) !important; }
        
        /* Flash Messages */
        div.bg-green-100 { background-color: rgba(16, 185, 129, 0.1) !important; border-color: #10b981 !important; color: #34d399 !important; }
    </style>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            @if(Auth::user()->patente === 'Ficheiro' || Auth::user()->patente === 'Conselheiro')
                <div class="mb-6 flex space-x-4">
                    <a href="{{ route('categorias.create') }}" class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded shadow">
                        + Nova Pasta
                    </a>
                    <a href="{{ route('fichas.create') }}" class="bg-green-600 hover:bg-green-700 text-white font-bold py-2 px-4 rounded shadow">
                        + Cadastrar Nova Carta
                    </a>
                    <a href="{{ route('loja.painel') }}" class="bg-purple-600 hover:bg-purple-700 text-white font-bold py-2 px-4 rounded shadow">
                        📋 Painel de Aprovações
                    </a>
                </div>
            @endif
            
            @if (session('sucesso'))
                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4 shadow-sm">
                    {{ session('sucesso') }}
                </div>
            @endif
            

            @if (session('erro'))
    <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4 shadow-sm">
        {{ session('erro') }}
    </div>
@endif

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-6">
                <div class="p-6">
                    <form method="GET" action="{{ route('fichas.index') }}" class="grid grid-cols-1 md:grid-cols-5 gap-4 items-end">
                        
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Buscar por Nome</label>
                            <input type="text" name="busca" value="{{ request('busca') }}" placeholder="Ex: Zona de Interferência" class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm">
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700">Categoria (Pasta)</label>
                            <select name="categoria_id" class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm">
                                <option value="">Todas as Pastas</option>
                                @foreach($categorias as $categoria)
                                    <option value="{{ $categoria->id }}" {{ request('categoria_id') == $categoria->id ? 'selected' : '' }}>
                                        {{ $categoria->nome }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700">Rank</label>
                            <select name="rank" class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm">
                                <option value="">Todos os Ranks</option>
                                <option value="Comum" {{ request('rank') == 'Comum' ? 'selected' : '' }}>Comum</option>
                                <option value="Raro" {{ request('rank') == 'Raro' ? 'selected' : '' }}>Raro</option>
                                <option value="Épico" {{ request('rank') == 'Épico' ? 'selected' : '' }}>Épico</option>
                                <option value="Divino" {{ request('rank') == 'Divino' ? 'selected' : '' }}>Divino</option>
                            </select>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700">Preço Máximo (Coins)</label>
                            <input type="number" name="preco_maximo" value="{{ request('preco_maximo') }}" class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm">
                        </div>

                        <div>
                            <button type="submit" class="w-full bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-2 px-4 rounded shadow-sm">
                                Filtrar Cartas
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @forelse($fichas as $ficha)
                    <div class="bg-white border-2 border-gray-200 rounded-xl shadow-lg overflow-hidden flex flex-col relative">
                        
                        <div class="bg-gray-800 text-white p-4 text-center border-b-4 border-indigo-500 relative">
                            <h3 class="font-black text-xl uppercase tracking-widest">{{ $ficha->titulo }}</h3>
                            <span class="absolute top-2 right-2 bg-indigo-500 text-xs px-2 py-1 rounded font-bold">{{ $ficha->rank }}</span>
                        </div>

                        <div class="p-5 flex-grow text-sm text-gray-700">
                            <div class="mb-4">
                                <p class="italic text-gray-600 border-l-4 border-gray-300 pl-3">"{{ $ficha->descricao_logica }}"</p>
                            </div>

                            <div class="bg-gray-50 p-3 rounded border border-gray-200 mb-4">
                                <p><strong>Energia (En):</strong> {{ $ficha->energia }}</p>
                                <p><strong>Fuga/Reação:</strong> {{ $ficha->fuga_reacao ?? 'Nenhuma' }}</p>
                                @if($ficha->usuario_exclusivo)
                                    <p class="text-red-600"><strong>Exclusivo de:</strong> {{ $ficha->usuario_exclusivo }}</p>
                                @endif
                                @if($ficha->link_referencia)
                                    <p class="mt-2"><a href="{{ $ficha->link_referencia }}" target="_blank" class="text-indigo-600 hover:underline">Ver Wiki Original</a></p>
                                @endif
                            </div>

                            <div>
                                <h4 class="font-bold text-gray-900 border-b border-gray-200 mb-2 pb-1">Observações</h4>
                                <p class="whitespace-pre-wrap">{{ $ficha->observacoes }}</p>
                            </div>
                        </div>

                        <div class="bg-gray-100 p-4 border-t border-gray-200 flex flex-col gap-2">
    <div class="flex justify-between items-center mb-2">
        <span class="text-xs text-gray-500 uppercase font-bold">{{ $ficha->categoria->nome ?? 'Sem Pasta' }}</span>
        <span class="font-black text-emerald-600 text-lg">{{ number_format($ficha->preco, 0, ',', '.') }} C</span>
    </div>

    <div class="flex flex-col gap-2">
        <form action="{{ route('loja.solicitar', $ficha->id) }}" method="POST" class="w-full">
            @csrf
            <button type="submit" class="w-full bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-2 px-4 rounded shadow-sm text-sm transition duration-150 ease-in-out">
                Solicitar Compra
            </button>
        </form>

        @if(Auth::user()->patente === 'Ficheiro' || Auth::user()->patente === 'Conselheiro')
            <form action="{{ route('fichas.destroy', $ficha->id) }}" method="POST" class="w-full" onsubmit="return confirm('Tem certeza que deseja excluir esta carta?');">
                @csrf
                @method('DELETE')
                <button type="submit" class="w-full bg-red-600 hover:bg-red-700 text-white font-bold py-2 px-4 rounded shadow-sm text-sm transition duration-150 ease-in-out">
                    Excluir Carta
                </button>
            </form>
        @endif
    </div>
</div>
                    </div>

                    
                @empty
                    <div class="col-span-full bg-white p-8 text-center rounded-lg shadow-sm">
                        <p class="text-gray-500 text-lg">Nenhuma carta encontrada. A biblioteca está vazia.</p>
                    </div>
                @endforelse
            </div>

        </div>
    </div>
</x-app-layout>