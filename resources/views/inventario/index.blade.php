<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Meu Deck (Inventário Pessoal)') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            <div class="mb-6">
                <h3 class="text-lg font-bold text-gray-700">Você possui {{ $itens->count() }} carta(s) diferente(s)</h3>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @forelse($itens as $item)
                    <div class="bg-white border-2 border-indigo-200 rounded-xl shadow-lg overflow-hidden flex flex-col relative transform transition hover:scale-105">
                        
                        <div class="absolute -top-3 -left-3 bg-indigo-600 text-white font-black rounded-full h-10 w-10 flex items-center justify-center border-4 border-white shadow-md z-10">
                            x{{ $item->quantidade }}
                        </div>

                        <div class="bg-gray-800 text-white p-4 text-center border-b-4 border-indigo-500 relative pl-8">
                            <h3 class="font-black text-xl uppercase tracking-widest">{{ $item->ficha->titulo }}</h3>
                            <span class="absolute top-2 right-2 bg-indigo-500 text-xs px-2 py-1 rounded font-bold">{{ $item->ficha->rank }}</span>
                        </div>

                        <div class="p-5 flex-grow text-sm text-gray-700">
                            <div class="mb-4">
                                <p class="italic text-gray-600 border-l-4 border-gray-300 pl-3">"{{ $item->ficha->descricao_logica }}"</p>
                            </div>

                            <div class="bg-gray-50 p-3 rounded border border-gray-200 mb-4">
                                <p><strong>Energia (En):</strong> {{ $item->ficha->energia }}</p>
                                <p><strong>Fuga/Reação:</strong> {{ $item->ficha->fuga_reacao ?? 'Nenhuma' }}</p>
                            </div>

                            <div>
                                <h4 class="font-bold text-gray-900 border-b border-gray-200 mb-2 pb-1">Observações</h4>
                                <p class="whitespace-pre-wrap">{{ $item->ficha->observacoes }}</p>
                            </div>
                        </div>

                        <div class="bg-indigo-50 p-4 border-t border-indigo-100 text-center">
                            <span class="text-xs text-indigo-500 uppercase font-bold">{{ $item->ficha->categoria->nome ?? 'Sem Pasta' }}</span>
                        </div>
                    </div>
                @empty
                    <div class="col-span-full bg-white p-8 text-center rounded-lg shadow-sm">
                        <p class="text-gray-500 text-lg">Seu inventário está vazio.</p>
                        <a href="{{ route('fichas.index') }}" class="mt-4 inline-block text-indigo-600 hover:text-indigo-800 font-bold underline">
                            Ir para a Biblioteca comprar cartas
                        </a>
                    </div>
                @endforelse
            </div>

        </div>
    </div>
</x-app-layout>