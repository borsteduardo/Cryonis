<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl leading-tight header-title text-pink-500 uppercase font-black">
            Auditoria de Missões
        </h2>
    </x-slot>

    <div class="py-12 max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
        @if (session('sucesso'))
            <div class="bg-green-900 border border-green-500 text-green-200 px-4 py-3 rounded">{{ session('sucesso') }}</div>
        @endif

        <div class="bg-[#09090b] border border-gray-800 rounded-lg p-6 text-white shadow-xl">
            <!-- Filtro -->
            <form method="GET" action="{{ route('admin.passes.verificacoes') }}" class="mb-8 flex items-end gap-4">
                <div class="flex-grow">
                    <label class="block text-xs text-gray-400 mb-1">Filtrar por Usuário:</label>
                    <select name="user_id" class="w-full bg-black border border-gray-700 rounded text-white text-sm focus:border-pink-500 focus:ring-1 focus:ring-pink-500">
                        <option value="">Todas as solicitações pendentes</option>
                        @foreach($usersFiltro as $uf)
                            <option value="{{ $uf->id }}" {{ request('user_id') == $uf->id ? 'selected' : '' }}>
                                {{ $uf->name }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <button type="submit" class="bg-gray-800 hover:bg-gray-700 px-4 py-2 rounded text-sm font-bold border border-gray-600 transition">Filtrar</button>
            </form>

            <!-- Lista -->
            <div class="space-y-4">
                @forelse($pendentes as $pendente)
                    <div class="flex flex-col md:flex-row justify-between items-center bg-[#111827] border-l-4 border-yellow-500 p-4 rounded">
                        <div>
                            <p class="text-xs text-gray-400 mb-1">Solicitado por: <strong class="text-indigo-400 text-sm">{{ $pendente->user->name }}</strong></p>
                            <h4 class="font-bold text-lg">{{ $pendente->missao->titulo }}</h4>
                            <p class="text-xs text-yellow-500 font-bold uppercase mt-1">Recompensa: +{{ $pendente->missao->xp_recompensa }} XP</p>
                        </div>
                        <div class="flex gap-2 mt-4 md:mt-0">
                            <form action="{{ route('admin.passes.verificacoes.aprovar', $pendente->id) }}" method="POST">
                                @csrf
                                <button type="submit" class="bg-green-600 hover:bg-green-500 px-4 py-2 rounded text-sm font-bold text-white shadow-lg transition">✅ Aprovar</button>
                            </form>
                            <form action="{{ route('admin.passes.verificacoes.recusar', $pendente->id) }}" method="POST" onsubmit="return confirm('Recusar esta missão? O jogador terá que fazê-la de novo.');">
                                @csrf
                                <button type="submit" class="bg-red-600 hover:bg-red-500 px-4 py-2 rounded text-sm font-bold text-white shadow-lg transition">❌ Recusar</button>
                            </form>
                        </div>
                    </div>
                @empty
                    <div class="text-center py-10 border border-dashed border-gray-700 rounded text-gray-500">
                        Nenhuma missão aguardando verificação no momento.
                    </div>
                @endforelse
            </div>
        </div>
    </div>
</x-app-layout>