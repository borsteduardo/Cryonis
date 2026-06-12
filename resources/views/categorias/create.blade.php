<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl leading-tight header-title">
            {{ __('Criar Nova Pasta') }}
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

        /* O "Cartão" do Formulário */
        .bg-white {
            background-color: #09090b !important;
            border: 1px solid rgba(147, 51, 234, 0.4) !important;
            box-shadow: 0 0 20px rgba(147, 51, 234, 0.15) !important;
            position: relative;
            color: #e5e7eb !important;
        }

        /* Linha de degradê no topo do cartão */
        .bg-white::before {
            content: ''; 
            position: absolute; 
            top: 0; left: 0; width: 100%; height: 3px;
            background: linear-gradient(90deg, #6d28d9, #db2777, #fca5a5);
        }

        /* Labels dos Inputs */
        label.text-gray-700 { 
            color: #d8b4fe !important; 
            font-weight: bold !important; 
        }

        /* Caixas de Texto (Inputs) */
        input[type="text"] {
            background-color: #030303 !important;
            border: 1px solid #4c1d95 !important;
            color: #ffffff !important;
            border-radius: 6px !important;
            padding: 10px 14px !important;
        }
        
        input[type="text"]:focus {
            border-color: #8b5cf6 !important;
            box-shadow: 0 0 10px rgba(139, 92, 246, 0.3) !important;
            outline: none !important;
        }

        /* Placeholder do input */
        input::placeholder {
            color: #52525b !important;
        }

        /* Botão Salvar Pasta */
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

        /* Link de Cancelar */
        a.text-gray-600 {
            color: #a1a1aa !important;
            transition: color 0.3s ease !important;
        }
        
        a.text-gray-600:hover {
            color: #ffffff !important;
            text-decoration: underline !important;
        }
    </style>

    <div class="py-12">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                <form action="{{ route('categorias.store') }}" method="POST">
                    @csrf
                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700">Nome da Pasta</label>
                        <input type="text" name="nome" placeholder="Ex: Magias de Fogo" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" required>
                    </div>
                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700">Descrição (Opcional)</label>
                        <input type="text" name="descricao" placeholder="Ex: Organização do baralho..." class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
                    </div>
                    
                    <div class="mt-6 flex items-center">
                        <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">Salvar Pasta</button>
                        <a href="{{ route('fichas.index') }}" class="ml-4 text-gray-600 hover:underline">Cancelar</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>