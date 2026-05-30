<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BancoController;
use App\Http\Controllers\FichaController; 
use App\Http\Controllers\CategoriaController;
use App\Http\Controllers\LojaController;
use App\Http\Controllers\InventarioController;

Route::get('/', function () {
    return redirect()->route('login');
});

Route::middleware(['auth', 'verified'])->group(function () {
    
    // --- DASHBOARD E PERFIL ---
    Route::get('/dashboard', function () { return view('dashboard'); })->name('dashboard');
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    
    // --- FICHAS E INVENTÁRIO (Acesso Geral) ---
    Route::get('/fichas', [FichaController::class, 'index'])->name('fichas.index');
    Route::get('/meu-inventario', [InventarioController::class, 'index'])->name('inventario.index');
    
    // --- LOJA (Solicitação Geral) ---
    Route::post('/loja/solicitar/{ficha_id}', [LojaController::class, 'solicitar'])->name('loja.solicitar');

    // --- BANCO (Visualização Geral) ---
    Route::get('/banco', [BancoController::class, 'index'])->name('banco.index');

    // --- ROTAS RESTRITAS (Ficheiro/Conselheiro) ---
    Route::middleware('patente:Ficheiro')->group(function () {
        Route::get('/categorias/criar', [CategoriaController::class, 'create'])->name('categorias.create');
        Route::post('/categorias', [CategoriaController::class, 'store'])->name('categorias.store');
        Route::get('/fichas/criar', [FichaController::class, 'create'])->name('fichas.create');
        Route::post('/fichas', [FichaController::class, 'store'])->name('fichas.store');
        Route::delete('/fichas/excluir/{id}', [FichaController::class, 'destroy'])->name('fichas.destroy');
        
        Route::get('/loja/aprovacoes', [LojaController::class, 'painelAprovacao'])->name('loja.painel');
        Route::post('/loja/aprovar/{id}', [LojaController::class, 'aprovar'])->name('loja.aprovar');
        Route::post('/loja/recusar/{id}', [LojaController::class, 'recusar'])->name('loja.recusar');
    });

    // --- ROTAS DE REGISTRO FINANCEIRO (Apenas Banqueiro) ---
    Route::post('/banco/transacao', [BancoController::class, 'store'])
         ->middleware('patente:Banqueiro')
         ->name('banco.store');
});

require __DIR__.'/auth.php';