<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl leading-tight header-title">
            {{ __('Painel de Aprovação da Loja') }}
        </h2>
    </x-slot>

    <style>
        /* Fundo principal da página */
        body, .min-h-screen, main, .bg-gray-100 { 
            background-color: #030303 !important; 
        }

        /* Título do Cabeçalho */
        .header-title {
            color: #a855f7 !important;
            text-transform: uppercase;
            letter-spacing: 2px;
            text-shadow: 0 0 10px rgba(147, 51, 234, 0.5);
            font-weight: 900 !important;
        }

        /* Cartão Principal */
        .bg-white {
            background-color: #09090b !important;
            border: 1px solid rgba(147, 51, 234, 0.4) !important;
            box-shadow: 0 0 20px rgba(147, 51, 234, 0.15) !important;
            position: relative;
            border-top-width: 1px !important; /* Remove a borda grossa do Tailwind antigo */
        }

        /* Linha de degradê no topo do cartão */
        .bg-white::before {
            content: ''; 
            position: absolute; 
            top: 0; left: 0; width: 100%; height: 3px;
            background: linear-gradient(90deg, #6d28d9, #db2777, #fca5a5);
        }

        /* Títulos e Textos */
        h3.text-gray-800 { color: #d8b4fe !important; font-weight: bold !important; }

        /* ================= ESTILOS DA TABELA ================= */
        table thead, .bg-gray-50 { 
            background-color: rgba(147, 51, 234, 0.1) !important; 
        }
        
        table th { 
            color: #d8b4fe !important; 
            border-bottom: 1px solid rgba(147, 51, 234, 0.3) !important; 
        }
        
        table tr { 
            border-bottom: 1px solid rgba(147, 51, 234, 0.1) !important; 
        }
        
        table tr:hover, tr.hover\:bg-gray-50:hover { 
            background-color: rgba(147, 51, 234, 0.05) !important; 
        }

        /* Células da Tabela */
        td.text-gray-500 { color: #a1a1aa !important; } /* Data e Texto de Mesa Limpa */
        td.text-indigo-600 { color: #c084fc !important; font-weight: bold !important; text-transform: uppercase; } /* Nome do Jogador */
        td.text-gray-900 { color: #e5e7eb !important; font-weight: bold !important; } /* Nome da Carta */
        
        /* Preço da Carta em Dourado */
        td.text-emerald-600 { 
            color: #fbbf24 !important; 
            font-weight: 900 !important; 
            text-shadow: 0 0 10px rgba(251, 191, 36, 0.3) !important; 
        }

        /* ================= BOTÕES DE AÇÃO ================= */
        
        /* Botão Aprovar */
        button.bg-green-500 {
            background: linear-gradient(90deg, #10b981, #059669) !important;
            border: 1px solid #34d399 !important;
            color: white !important;
            transition: all 0.3s ease !important;
        }
        button.bg-green-500:hover { 
            box-shadow: 0 0 15px rgba(16, 185, 129, 0.4) !important; 
            transform: scale(1.05) !important; 
        }

        /* Botão Recusar */
        button.bg-red-500 {
            background: linear-gradient(90deg, #dc2626, #991b1b) !important;
            border: 1px solid #f87171 !important;
            color: white !important;
            transition: all 0.3s ease !important;
        }
        button.bg-red-500:hover { 
            box-shadow: 0 0 15px rgba(239, 68, 68, 0.4) !important; 
            transform: scale(1.05) !important; 
        }

        /* ================= MENSAGENS DE ALERTA ================= */
        div.bg-green-100 { 
            background-color: rgba(16, 185, 129, 0.1) !important; 
            border-color: #10b981 !important; 
            color: #34d399 !important; 
        }
        div.bg-red-100 { 
            background-color: rgba(239, 68, 68, 0.1) !important; 
            border-color: #ef4444 !important; 
            color: #f87171 !important; 
        }
    </style>

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