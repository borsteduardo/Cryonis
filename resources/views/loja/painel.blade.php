<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl leading-tight header-title">
            {{ __('Painel de Aprovação da Loja') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
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

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg border-t-4 border-indigo-500">
                <div class="p-6 text-gray-900">
                    <h3 class="font-bold text-lg mb-4 text-gray-800">Solicitações Pendentes</h3>
                    
                    <div class="overflow-x-auto">
                        <table class="min-w-full text-left text-sm whitespace-nowrap">
                            <thead class="uppercase tracking-wider border-b-2 border-gray-200 bg-gray-50">
                                <tr>
                                    <th class="px-6 py-4">Data</th>
                                    <th class="px-6 py-4">Jogador</th>
                                    <th class="px-6 py-4">Carta Solicitada</th>
                                    <th class="px-6 py-4">Preço</th>
                                    <th class="px-6 py-4">Ações</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($solicitacoes as $pedido)
                                <tr class="border-b hover:bg-gray-50">
                                    <td class="px-6 py-4 text-gray-500">{{ $pedido->created_at->format('d/m/Y H:i') }}</td>
                                    <td class="px-6 py-4 font-bold text-indigo-600">{{ $pedido->user->name }}</td>
                                    <td class="px-6 py-4 font-medium text-gray-900">{{ $pedido->ficha->titulo }}</td>
                                    <td class="px-6 py-4 font-black text-emerald-600">{{ number_format($pedido->ficha->preco, 0, ',', '.') }} C</td>
                                    <td class="px-6 py-4 flex space-x-2">
                                        <form action="{{ route('loja.aprovar', $pedido->id) }}" method="POST">
                                            @csrf
                                            <button type="submit" class="bg-green-500 hover:bg-green-600 text-white font-bold py-1 px-3 rounded shadow-sm text-xs transition duration-150">
                                                Aprovar e Descontar
                                            </button>
                                        </form>
                                        
                                        <form action="{{ route('loja.recusar', $pedido->id) }}" method="POST">
                                            @csrf
                                            <button type="submit" class="bg-red-500 hover:bg-red-600 text-white font-bold py-1 px-3 rounded shadow-sm text-xs transition duration-150">
                                                Recusar
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="5" class="px-6 py-8 text-center text-gray-500">
                                        Nenhuma solicitação de compra pendente no momento. Sua mesa está limpa!
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

        </div>
    </div>
</x-app-layout>