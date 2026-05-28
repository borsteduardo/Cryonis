<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Ficha;
use App\Models\Categoria;

class FichaController extends Controller
{
    // Função para exibir as cartas e processar os filtros
    public function index(Request $request)
    {
        $categorias = Categoria::all();
        
        $query = Ficha::query();

        // FILTROS
        if ($request->filled('categoria_id')) {
            $query->where('categoria_id', $request->categoria_id);
        }

        if ($request->filled('rank')) {
            $query->where('rank', $request->rank);
        }

        if ($request->filled('preco_maximo')) {
            $query->where('preco', '<=', $request->preco_maximo);
        }

        if ($request->filled('busca')) {
            $query->where('titulo', 'like', '%' . $request->busca . '%');
        }

        $fichas = $query->with('categoria')->get();

        return view('fichas.index', compact('fichas', 'categorias'));
    }

    // Mostra o formulário de criar carta
    public function create()
    {
        $categorias = Categoria::all();
        return view('fichas.create', compact('categorias'));
    }

    // Salva a carta no banco de dados
    public function store(Request $request)
    {
        $request->validate([
            'categoria_id' => 'required|exists:categorias,id',
            'titulo' => 'required|string|max:255',
            'link_referencia' => 'nullable|url',
            'rank' => 'required|string',
            'descricao_logica' => 'required|string',
            'energia' => 'nullable|string|max:255',
            'observacoes' => 'nullable|string',
            'fuga_reacao' => 'nullable|string|max:255',
            'preco' => 'required|numeric|min:0',
            'usuario_exclusivo' => 'nullable|string|max:255',
        ]);

        Ficha::create($request->all());

        return redirect()->route('fichas.index')->with('sucesso', 'Carta cadastrada com sucesso!');
    }
}