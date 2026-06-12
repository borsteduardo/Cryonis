<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl leading-tight header-title">
            {{ __('Gerenciador do Passe de Batalha') }}
        </h2>
    </x-slot>

    <div class="py-12 max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">

        @if (session('sucesso'))
            <div class="bg-green-900 border border-green-500 text-green-200 px-4 py-3 rounded relative shadow-sm mb-4">
                {{ session('sucesso') }}
            </div>
        @endif

        <div class="dark-box">
            <h3 class="text-xl font-bold text-indigo-400 mb-4">+ Cadastrar Nova Temporada</h3>
            <form action="{{ route('admin.passes.store') }}" method="POST" class="grid grid-cols-1 md:grid-cols-4 gap-4 items-end">
                @csrf
                <div>
                    <label class="text-sm font-medium text-gray-400">Nome do Passe</label>
                    <input type="text" name="nome" placeholder="Ex: Temporada 1" required class="input-dark">
                </div>
                <div>
                    <label class="text-sm font-medium text-gray-400">Data de Início</label>
                    <input type="date" name="data_inicio" required class="input-dark">
                </div>
                <div>
                    <label class="text-sm font-medium text-gray-400">Data de Término</label>
                    <input type="date" name="data_fim" required class="input-dark">
                </div>
                <div class="flex items-center space-x-2 pb-2">
                    <input type="checkbox" name="ativo" value="1" class="rounded bg-black border-gray-700 text-indigo-600 focus:ring-indigo-500">
                    <label class="text-sm font-medium text-gray-400">Ativar Imediatamente</label>
                </div>
                <div class="md:col-span-4 mt-2">
                    <button type="submit" class="btn-submit">Criar Temporada</button>
                </div>
            </form>
        </div>

        @foreach($passes as $passe)
            <div class="dark-box border-2 {{ $passe->ativo ? 'border-green-600 shadow-[0_0_15px_rgba(22,163,74,0.3)]' : 'border-gray-700' }}">
                <div class="flex justify-between items-center mb-6 border-b border-gray-800 pb-4">
                    <div>
                        <h2 class="text-2xl font-black text-white uppercase">{{ $passe->nome }}</h2>
                        <p class="text-sm text-gray-400">De {{ $passe->data_inicio->format('d/m/Y') }} até {{ $passe->data_fim->format('d/m/Y') }}</p>
                    </div>
                    <div>
                        @if($passe->ativo)
                            <span class="bg-green-900 text-green-300 py-1 px-3 rounded text-xs font-bold border border-green-500 uppercase">Temporada Ativa</span>
                        @else
                            <span class="bg-gray-800 text-gray-400 py-1 px-3 rounded text-xs font-bold border border-gray-600 uppercase">Inativa</span>
                        @endif
                    </div>
                </div>

                <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
                    
                    <div class="bg-black/50 p-4 rounded-lg border border-gray-800">
                        <h4 class="text-lg font-bold text-pink-500 mb-4 border-b border-gray-800 pb-2">Níveis & Recompensas</h4>
                        
                        <form action="{{ route('admin.passes.nivel.store', $passe->id) }}" method="POST" class="grid grid-cols-2 gap-2 mb-6">
                            @csrf
                            <div>
                                <label class="text-xs text-gray-400">Nível</label>
                                <input type="number" name="nivel" required class="input-dark text-sm">
                            </div>
                            <div>
                                <label class="text-xs text-gray-400">XP Necessário (Total)</label>
                                <input type="number" name="xp_necessario" required class="input-dark text-sm">
                            </div>
                            <div>
                                <label class="text-xs text-gray-400">Tipo da Recompensa</label>
                                <select name="recompensa_tipo" class="input-dark text-sm">
                                    <option value="moeda">Coins (Dinheiro)</option>
                                    <option value="giro">Giro no Gacha</option>
                                    <option value="chibi">Chibi (ID Específico)</option>
                                    <option value="ficha">Ficha (ID Específico)</option>
                                </select>
                            </div>
                            <div>
                                <label class="text-xs text-gray-400">ID do Item (Se Chibi/Ficha)</label>
                                <input type="number" name="recompensa_id" class="input-dark text-sm" placeholder="Deixe vazio p/ Moeda/Giro">
                            </div>
                            <div>
                                <label class="text-xs text-gray-400">Quantidade (Valor/Giros)</label>
                                <input type="number" name="quantidade" value="1" required class="input-dark text-sm">
                            </div>
                            <div class="flex items-center mt-6">
                                <input type="checkbox" name="is_premium" value="1" class="rounded bg-black border-gray-700 text-pink-500 mr-2">
                                <label class="text-xs text-gray-400">Premium (Passe Pago)</label>
                            </div>
                            <div class="col-span-2">
                                <button type="submit" class="bg-gray-800 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded w-full text-xs mt-2 border border-gray-600 transition">Adicionar Nível</button>
                            </div>
                        </form>

                        <div class="max-h-64 overflow-y-auto pr-2">
                            <table class="table-dark">
                                <thead>
                                    <tr><th>Nv</th><th>XP Total</th><th>Recompensa</th><th>Qtd</th><th>Tipo</th></tr>
                                </thead>
                                <tbody>
                                    @forelse($passe->niveis->sortBy('nivel') as $nivel)
                                        <tr class="{{ $nivel->is_premium ? 'text-pink-300' : 'text-gray-300' }}">
                                            <td class="font-bold">{{ $nivel->nivel }}</td>
                                            <td>{{ $nivel->xp_necessario }}</td>
                                            <td class="uppercase text-xs">{{ $nivel->recompensa_tipo }} {{ $nivel->recompensa_id ? '#'.$nivel->recompensa_id : '' }}</td>
                                            <td>{{ $nivel->quantidade }}x</td>
                                            <td class="text-xs">{{ $nivel->is_premium ? 'Premium' : 'Grátis' }}</td>
                                        </tr>
                                    @empty
                                        <tr><td colspan="5" class="text-center italic text-gray-500 py-4">Nenhum nível cadastrado.</td></tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <div class="bg-black/50 p-4 rounded-lg border border-gray-800">
                        <h4 class="text-lg font-bold text-indigo-400 mb-4 border-b border-gray-800 pb-2">Tarefas & Missões</h4>
                        
                        <form action="{{ route('admin.passes.missao.store', $passe->id) }}" method="POST" class="grid grid-cols-2 gap-2 mb-6">
                            @csrf
                            <div class="col-span-2">
                                <label class="text-xs text-gray-400">Título da Missão</label>
                                <input type="text" name="titulo" required class="input-dark text-sm">
                            </div>
                            <div class="col-span-2">
                                <label class="text-xs text-gray-400">Descrição (Opcional)</label>
                                <input type="text" name="descricao" class="input-dark text-sm">
                            </div>
                            <div>
                                <label class="text-xs text-gray-400">Tipo / Frequência</label>
                                <select name="tipo" class="input-dark text-sm">
                                    <option value="diaria">Diária</option>
                                    <option value="semanal">Semanal</option>
                                    <option value="mensal">Mensal</option>
                                    <option value="temporada">Temporada Inteira</option>
                                </select>
                            </div>
                            <div>
                                <label class="text-xs text-gray-400">Recompensa (XP)</label>
                                <input type="number" name="xp_recompensa" required class="input-dark text-sm">
                            </div>
                            <div class="col-span-2">
                                <button type="submit" class="bg-gray-800 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded w-full text-xs mt-2 border border-gray-600 transition">Adicionar Missão</button>
                            </div>
                        </form>

                        <div class="max-h-64 overflow-y-auto pr-2">
                            <table class="table-dark">
                                <thead>
                                    <tr><th>Missão</th><th>Tipo</th><th>XP</th></tr>
                                </thead>
                                <tbody>
                                    @forelse($passe->missoes->sortBy('tipo') as $missao)
                                        <tr>
                                            <td>
                                                <span class="font-bold block">{{ $missao->titulo }}</span>
                                                <span class="text-xs text-gray-500">{{ $missao->descricao }}</span>
                                            </td>
                                            <td class="uppercase text-xs text-indigo-400">{{ $missao->tipo }}</td>
                                            <td class="font-bold text-yellow-500">+{{ $missao->xp_recompensa }}</td>
                                        </tr>
                                    @empty
                                        <tr><td colspan="3" class="text-center italic text-gray-500 py-4">Nenhuma missão cadastrada.</td></tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>

                </div>
            </div>
        @endforeach

    </div>
</x-app-layout>