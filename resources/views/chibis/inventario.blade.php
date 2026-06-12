<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl leading-tight header-title">
            {{ __('Meu Inventário de Chibis') }}
        </h2>
    </x-slot>

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