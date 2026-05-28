<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Categoria;

class CategoriaController extends Controller
{
    // Mostra o formulário de criar pasta
    public function create()
    {
        return view('categorias.create');
    }

    // Salva a pasta no banco de dados
    public function store(Request $request)
    {
        $request->validate([
            'nome' => 'required|string|max:255',
            'descricao' => 'nullable|string|max:255',
        ]);

        Categoria::create($request->all());

        return redirect()->route('fichas.index')->with('sucesso', 'Pasta criada com sucesso!');
    }
}