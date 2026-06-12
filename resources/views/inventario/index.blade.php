<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl leading-tight header-title">
            {{ __('Meu Deck (Inventário Pessoal)') }}
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

        /* Textos e Títulos fora das cartas */
        h3.text-gray-700 { color: #d8b4fe !important; font-weight: bold !important; }

        /* ================= O PADRÃO DE "CARTÃO" DO SITE ================= */
        
        .bg-white {
            background-color: #09090b !important;
            border: 1px solid rgba(147, 51, 234, 0.4) !important;
            box-shadow: 0 0 20px rgba(147, 51, 234, 0.15) !important;
            color: #e5e7eb !important;
            position: relative;
            overflow: visible !important; /* Deixa o badge x1 vazar pra fora */
        }

        /* Linha de degradê no topo das cartas (A assinatura visual do site) */
        .bg-white::before {
            content: ''; 
            position: absolute; 
            top: 0; left: 0; width: 100%; height: 3px;
            background: linear-gradient(90deg, #6d28d9, #db2777, #fca5a5);
            border-top-left-radius: 10px;
            border-top-right-radius: 10px;
        }

        /* Efeito ao passar o mouse na carta */
        .bg-white.rounded-xl:hover {
            transform: translateY(-5px) scale(1.02) !important;
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.6), 0 0 15px rgba(147, 51, 234, 0.4) !important;
            border-color: #a855f7 !important;
            z-index: 10;
        }

        /* Badge de Quantidade (Bolinha x1, x2) */
        .rounded-full {
            background: linear-gradient(90deg, #6d28d9, #db2777) !important; /* Mesmo degradê dos botões principais */
            border: 2px solid #030303 !important; /* Borda preta pra destacar do fundo */
            box-shadow: 0 0 10px rgba(219, 39, 119, 0.5) !important;
        }

        /* Cabeçalho da Carta (Igual ao thead da tabela do Banco) */
        .bg-gray-800 {
            background-color: rgba(147, 51, 234, 0.1) !important; 
            border-bottom: 1px solid rgba(147, 51, 234, 0.3) !important;
        }
        
        .bg-gray-800 h3 {
            color: #d8b4fe !important;
        }

        /* Rank da Carta (Comum, Raro, etc) */
        .bg-indigo-500 {
            background-color: #9333ea !important;
            box-shadow: 0 0 8px rgba(147, 51, 234, 0.4) !important;
            border: 1px solid rgba(255,255,255,0.2) !important;
        }

        /* Textos Gerais dentro da Carta */
        .text-gray-700 { color: #e5e7eb !important; }
        
        /* Citação (Descrição Lógica) */
        .border-gray-300 { border-color: #8b5cf6 !important; }
        .text-gray-600 { color: #a1a1aa !important; }

        /* Área de Stats (Energia / Fuga) */
        .bg-gray-50 {
            background-color: rgba(0,0,0,0.3) !important;
            border: 1px solid rgba(147, 51, 234, 0.2) !important;
        }
        strong { color: #d8b4fe !important; }

        /* Observações */
        h4.text-gray-900 { 
            color: #d8b4fe !important; 
            border-color: rgba(147, 51, 234, 0.2) !important; 
        }

        /* Rodapé da Carta (Categoria) - Igual ao hover da tabela do Banco */
        .bg-indigo-50 {
            background-color: rgba(147, 51, 234, 0.05) !important;
            border-top: 1px solid rgba(147, 51, 234, 0.3) !important;
        }
        .text-indigo-500 { color: #a1a1aa !important; }

        /* ================= ESTADO VAZIO (Nenhuma Carta) ================= */
        .col-span-full.bg-white {
            background-color: #09090b !important;
            border: 1px dashed rgba(147, 51, 234, 0.4) !important;
        }
        .text-gray-500 { color: #a1a1aa !important; }
        
        /* Link de ir para a biblioteca - Transformado no Botão Padrão do Site */
        a.text-indigo-600 { 
            background: linear-gradient(90deg, #6d28d9, #db2777) !important;
            color: white !important; 
            text-decoration: none !important; 
            padding: 10px 20px !important; 
            border-radius: 6px !important; 
            transition: all 0.3s !important; 
            display: inline-block !important; 
            font-weight: bold !important;
            border: none !important;
        }
        a.text-indigo-600:hover { 
            opacity: 0.9 !important;
            transform: scale(1.02) !important;
            box-shadow: 0 0 15px rgba(219, 39, 119, 0.4) !important; 
        }
    </style>

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
                        <p class="text-gray-500 text-lg mb-4">Seu inventário está vazio. O baralho ainda não foi formado.</p>
                        <a href="{{ route('fichas.index') }}" class="mt-4 inline-block text-indigo-600 hover:text-indigo-800 font-bold underline">
                            Ir para a Biblioteca comprar cartas
                        </a>
                    </div>
                @endforelse
            </div>

        </div>
    </div>
</x-app-layout>