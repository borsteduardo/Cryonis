<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl leading-tight header-title">
            {{ __('Banco Central do RPG') }}
        </h2>
    </x-slot>

    <style>
        /* Fundo da página */
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

        /* Os "Cartões" Base */
        .bg-white, .bg-gray-800 {
            background-color: #09090b !important;
            border: 1px solid rgba(147, 51, 234, 0.4) !important;
            box-shadow: 0 0 20px rgba(147, 51, 234, 0.15) !important;
            position: relative;
            color: #e5e7eb !important;
            border-left-width: 1px !important; /* Remove aquela borda grossa azul */
        }

        /* Linha de degradê no topo de todos os cartões */
        .bg-white::before, .bg-gray-800::before {
            content: ''; 
            position: absolute; 
            top: 0; left: 0; width: 100%; height: 3px;
            background: linear-gradient(90deg, #6d28d9, #db2777, #fca5a5);
        }

        /* Textos e Labels */
        h3.text-gray-800, h3.text-gray-600 { color: #d8b4fe !important; font-weight: bold !important; }
        label.text-gray-700 { color: #d8b4fe !important; font-weight: bold !important; }
        p.text-gray-500, span.text-gray-500 { color: #a1a1aa !important; }

        /* Valor do Saldo (Mantém um leve destaque) */
        .text-5xl { color: #fff !important; font-weight: 900 !important; text-shadow: 0 0 15px rgba(147, 51, 234, 0.3) !important; }

        /* Inputs e Selects no padrão do Perfil */
        input[type="number"], input[type="text"], select {
            background-color: #030303 !important;
            border: 1px solid #4c1d95 !important;
            color: #ffffff !important;
            border-radius: 6px !important;
        }
        
        input:focus, select:focus {
            border-color: #8b5cf6 !important;
            box-shadow: 0 0 10px rgba(139, 92, 246, 0.3) !important;
            outline: none !important;
        }

        select option {
            background-color: #09090b !important;
            color: #fff !important;
        }

        /* Área dos Checkboxes */
        .overflow-y-auto {
            background-color: #030303 !important;
            border: 1px solid #4c1d95 !important;
        }
        .overflow-y-auto span {
            color: #e5e7eb !important;
        }
        input[type="checkbox"] {
            accent-color: #8b5cf6 !important;
        }

        /* Botão Confirmar Transação (O mesmo do Profile/Login) */
        button.bg-blue-600 {
            background: linear-gradient(90deg, #6d28d9, #db2777) !important;
            border: none !important;
            color: white !important;
            transition: all 0.3s ease !important;
            font-weight: bold !important;
        }
        button.bg-blue-600:hover {
            opacity: 0.9 !important;
            transform: scale(1.02) !important;
            box-shadow: 0 0 15px rgba(219, 39, 119, 0.4) !important;
        }

        /* ================= ESTILOS DA TABELA ================= */
        table thead { background-color: rgba(147, 51, 234, 0.1) !important; }
        table th { color: #d8b4fe !important; border-bottom: 1px solid rgba(147, 51, 234, 0.3) !important; }
        table tr { border-bottom: 1px solid rgba(147, 51, 234, 0.1) !important; }
        table tr:hover { background-color: rgba(147, 51, 234, 0.05) !important; }
        
        td.text-gray-500 { color: #a1a1aa !important; } 
        td.text-gray-900 { color: #e5e7eb !important; font-weight: bold !important; } 
        td.\.\.\. { color: #fff !important; font-weight: bold !important; }

        /* Mensagens de Sucesso e Erro */
        div.bg-green-100 { background-color: rgba(16, 185, 129, 0.1) !important; border-color: #10b981 !important; color: #34d399 !important; }
        div.bg-red-100 { background-color: rgba(239, 68, 68, 0.1) !important; border-color: #ef4444 !important; color: #f87171 !important; }
        span.bg-emerald-100 { background-color: rgba(16, 185, 129, 0.15) !important; color: #34d399 !important; border: 1px solid #10b981 !important; }
        span.bg-red-100 { background-color: rgba(239, 68, 68, 0.15) !important; color: #f87171 !important; border: 1px solid #ef4444 !important; }
    </style>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            @if (session('sucesso'))
                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4">
                    {{ session('sucesso') }}
                </div>
            @endif
            @if (session('erro'))
                <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4">
                    {{ session('erro') }}
                </div>
            @endif

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-6">
                <div class="p-6 text-center">
                    <h3 class="text-lg font-bold text-gray-600 uppercase tracking-widest">Seu Saldo Atual</h3>
                    <p class="text-5xl ... mt-2">{{ number_format($saldo, 2, ',', '.') }} <span class="text-2xl text-gray-500">Coins</span></p>
                </div>
            </div>

            @if(Auth::user()->patente === 'Banqueiro' || Auth::user()->patente === 'Conselheiro')
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-6">
                <div class="p-6">
                    <h3 class="font-bold text-lg mb-4 text-gray-800">Registrar Nova Transação</h3>
                    <form action="{{ route('banco.store') }}" method="POST">
                        @csrf
                        <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                            
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Jogadores (Marque um ou mais)</label>
                                <div class="max-h-24 overflow-y-auto border border-gray-300 rounded-md p-2 shadow-sm bg-white">
                                    @foreach($todosJogadores as $jogador)
                                        <label class="inline-flex items-center w-full mb-1 cursor-pointer">
                                            <input type="checkbox" name="jogadores_id[]" value="{{ $jogador->id }}" class="rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500">
                                            <span class="ml-2 text-sm text-gray-700">{{ $jogador->name }}</span>
                                        </label>
                                    @endforeach
                                </div>
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700">Tipo de Movimentação</label>
                                <select name="tipo" class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm">
                                    <option value="entrada">Entrada (+)</option>
                                    <option value="saida">Saída (-)</option>
                                </select>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Valor (Coins)</label>
                                <input type="number" step="0.01" min="0.01" name="valor" class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm" required>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Descrição</label>
                                <input type="text" name="descricao" placeholder="Ex: Salário da missão" class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm" required>
                            </div>
                        </div>
                        <button type="submit" class="mt-4 bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                            Confirmar Transação
                        </button>
                    </form>
                </div>
            </div>
            @endif

            <div class="bg-gray-800 border border-gray-700 overflow-hidden shadow-xl sm:rounded-2xl">
                <div class="p-6">
                    <h3 class="font-bold text-lg mb-4 text-gray-800">Extrato de Transações</h3>
                    <div class="overflow-x-auto">
                        <table class="min-w-full text-left text-sm whitespace-nowrap">
                            <thead class="uppercase tracking-wider border-b-2 border-gray-200 bg-gray-50">
                                <tr>
                                    <th class="px-6 py-4">Data</th>
                                    <th class="px-6 py-4">Descrição</th>
                                    <th class="px-6 py-4">Tipo</th>
                                    <th class="px-6 py-4">Valor</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($transacoes as $transacao)
                                <tr class="border-b hover:bg-gray-50">
                                    <td class="px-6 py-4 text-gray-500">{{ $transacao->created_at->format('d/m/Y H:i') }}</td>
                                    <td class="px-6 py-4 font-medium text-gray-900">{{ $transacao->descricao }}</td>
                                    <td class="px-6 py-4">
                                        @if($transacao->tipo == 'entrada')
                                            <span class="text-emerald-600 font-bold bg-emerald-100 px-2 py-1 rounded">Entrada</span>
                                        @else
                                            <span class="text-red-600 font-bold bg-red-100 px-2 py-1 rounded">Saída</span>
                                        @endif
                                    </td>
                                    <td class="...">{{ number_format($transacao->valor, 2, ',', '.') }} Coins</td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="4" class="px-6 py-4 text-center text-gray-500">Nenhuma transação registrada ainda. O seu extrato está vazio.</td>
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