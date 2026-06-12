<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl leading-tight header-title">
            {{ __('Biblioteca de Cartas e Fichas') }}
        </h2>
    </x-slot>

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