<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Cadastrar Nova Carta</h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-5xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6 border-t-4 border-indigo-500">
                <form action="{{ route('fichas.store') }}" method="POST">
                    @csrf
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Título da Carta</label>
                            <input type="text" name="titulo" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" required>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Pasta (Categoria)</label>
                            <select name="categoria_id" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" required>
                                <option value="" disabled selected>Escolha uma pasta...</option>
                                @foreach($categorias as $categoria)
                                    <option value="{{ $categoria->id }}">{{ $categoria->nome }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Rank</label>
                            <select name="rank" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
                                <option value="Comum">Comum</option>
                                <option value="Raro">Raro</option>
                                <option value="Épico">Épico</option>
                                <option value="Divino">Divino</option>
                            </select>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Preço (Coins)</label>
                            <input type="number" name="preco" value="0" min="0" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" required>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Custo de Energia (En)</label>
                            <input type="text" name="energia" placeholder="Ex: 20.000 p/uso" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
                        </div>
                    </div>

                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700">Descrição Lógica</label>
                        <textarea name="descricao_logica" rows="3" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" required></textarea>
                    </div>

                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700">Observações / Regras</label>
                        <textarea name="observacoes" rows="4" placeholder="Regras de uso, cooldown, etc..." class="mt-1 block w-full border-gray-300 rounded-md shadow-sm"></textarea>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-6">
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Fuga / Reação</label>
                            <input type="text" name="fuga_reacao" placeholder="Ex: Apenas Esquiva" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Usuário Exclusivo</label>
                            <input type="text" name="usuario_exclusivo" placeholder="Ex: Shiba Miyuki (Opcional)" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Link de Referência (Wiki)</label>
                            <input type="url" name="link_referencia" placeholder="https://..." class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
                        </div>
                    </div>

                    <div class="flex items-center">
                        <button type="submit" class="bg-green-600 hover:bg-green-700 text-white font-bold py-2 px-6 rounded shadow">Cadastrar Carta</button>
                        <a href="{{ route('fichas.index') }}" class="ml-4 text-gray-600 hover:underline">Voltar para Biblioteca</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>