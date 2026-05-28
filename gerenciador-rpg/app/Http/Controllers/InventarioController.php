<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Inventario; // A linha salvadora está bem aqui!
use Illuminate\Support\Facades\Auth;

class InventarioController extends Controller
{
    public function index()
    {
        // Busca os itens do inventário do jogador logado.
        $itens = Inventario::with(['ficha.categoria'])
                            ->where('user_id', Auth::id())
                            ->get();

        return view('inventario.index', compact('itens'));
    }
}