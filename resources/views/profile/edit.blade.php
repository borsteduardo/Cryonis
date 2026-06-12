<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl leading-tight header-title">
            {{ __('Profile') }}
        </h2>
    </x-slot>

    <style>
        /* Fundo principal da página */
        body, .min-h-screen, main, .bg-gray-100 { 
            background-color: #030303 !important; 
        }

        /* Estilo do cabeçalho */
        header {
            background-color: #09090b !important;
            border-bottom: 1px solid rgba(147, 51, 234, 0.3) !important;
            box-shadow: 0 4px 20px rgba(147, 51, 234, 0.05) !important;
        }

        /* Título "Profile" */
        .header-title {
            color: #a855f7 !important;
            text-transform: uppercase;
            letter-spacing: 2px;
            text-shadow: 0 0 10px rgba(147, 51, 234, 0.5);
            font-weight: 900 !important;
        }

        /* Os 3 Cartões de Configuração */
        .bg-white, .dark\:bg-gray-800 {
            background-color: #09090b !important;
            border: 1px solid rgba(147, 51, 234, 0.4) !important;
            box-shadow: 0 0 20px rgba(147, 51, 234, 0.15) !important;
            position: relative;
        }

        /* Linha de degradê no topo dos cartões */
        .bg-white::before {
            content: ''; 
            position: absolute; 
            top: 0; left: 0; width: 100%; height: 3px;
            background: linear-gradient(90deg, #6d28d9, #db2777, #fca5a5);
        }

        /* Textos dentro dos formulários */
        h2.text-gray-900, h2.dark\:text-gray-100 { 
            color: #d8b4fe !important; 
            font-weight: bold !important; 
        }
        p.text-gray-600, p.dark\:text-gray-400 { 
            color: #a1a1aa !important; 
        }

        /* Labels dos Inputs */
        label { 
            color: #d8b4fe !important; 
            font-weight: bold !important; 
        }

        /* Caixas de Texto (Inputs) */
        input[type="text"], input[type="email"], input[type="password"] {
            background-color: #030303 !important;
            border: 1px solid #4c1d95 !important;
            color: #ffffff !important;
            border-radius: 6px !important;
            padding: 10px 14px !important;
        }
        input:focus {
            border-color: #8b5cf6 !important;
            box-shadow: 0 0 10px rgba(139, 92, 246, 0.3) !important;
            outline: none !important;
        }

        /* ================= ESTILOS DOS BOTÕES ================= */
        
        /* Botão Principal (Save) - Ocultando as classes antigas */
        button.bg-gray-800 {
            background: linear-gradient(90deg, #6d28d9, #db2777) !important;
            color: white !important;
            border: none !important;
            font-weight: bold !important;
            transition: all 0.3s ease !important;
        }
        button.bg-gray-800:hover { 
            opacity: 0.9 !important; 
            transform: scale(1.02) !important; 
            box-shadow: 0 0 15px rgba(219, 39, 119, 0.4) !important; 
        }

        /* Botão de Perigo (Delete Account) */
        button.bg-red-600 {
            background: linear-gradient(90deg, #991b1b, #dc2626) !important;
            border: 1px solid #ef4444 !important;
            color: white !important;
            font-weight: bold !important;
        }
        button.bg-red-600:hover { 
            box-shadow: 0 0 15px rgba(239, 68, 68, 0.5) !important; 
        }

        /* Botão Secundário (Cancel na Modal) */
        button.bg-white {
            background: transparent !important;
            border: 1px solid #4c1d95 !important;
            color: #d8b4fe !important;
        }
        button.bg-white:hover { 
            background: rgba(147, 51, 234, 0.15) !important; 
        }
    </style>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <div class="p-4 sm:p-8 bg-white dark:bg-gray-800 shadow sm:rounded-lg">
                <div class="max-w-xl">
                    @include('profile.partials.update-profile-information-form')
                </div>
            </div>

            <div class="p-4 sm:p-8 bg-white dark:bg-gray-800 shadow sm:rounded-lg">
                <div class="max-w-xl">
                    @include('profile.partials.update-password-form')
                </div>
            </div>

            <div class="p-4 sm:p-8 bg-white dark:bg-gray-800 shadow sm:rounded-lg">
                <div class="max-w-xl">
                    @include('profile.partials.delete-user-form')
                </div>
            </div>
        </div>
    </div>
</x-app-layout>