<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl leading-tight header-title">
            {{ __('Painel Central') }}
        </h2>
    </x-slot>

    <style>
        /* Força o fundo da página inteira a ficar escuro */
        body, .min-h-screen, main, .bg-gray-100 {
            background-color: #030303 !important;
        }

        /* Estiliza o cabeçalho padrão do Laravel */
        header {
            background-color: #09090b !important;
            border-bottom: 1px solid rgba(147, 51, 234, 0.3) !important;
            box-shadow: 0 4px 20px rgba(147, 51, 234, 0.05) !important;
        }

        /* Estiliza o título do cabeçalho */
        .header-title {
            color: #a855f7 !important; /* Roxo neon */
            text-transform: uppercase;
            letter-spacing: 2px;
            text-shadow: 0 0 10px rgba(147, 51, 234, 0.5);
            font-weight: 900 !important;
        }

        /* Sobrescreve os "cartões" brancos do Laravel */
        .bg-white {
            background-color: #09090b !important;
            border: 1px solid rgba(147, 51, 234, 0.4) !important;
            box-shadow: 0 0 20px rgba(147, 51, 234, 0.15) !important;
            position: relative;
        }

        /* Cria a linha de degradê no topo do cartão */
        .bg-white::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 3px;
            background: linear-gradient(90deg, #6d28d9, #db2777, #fca5a5);
        }

        /* Clareia os textos que antes eram escuros */
        .text-gray-900, .text-gray-800, .text-gray-700 {
            color: #e5e7eb !important;
        }
    </style>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 text-lg">
                    {{ __("Acesso autorizado. Você está logado no sistema!") }}
                </div>
            </div>
        </div>
    </div>
</x-app-layout>