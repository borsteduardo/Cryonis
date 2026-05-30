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

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    // Qualquer jogador logado pode pedir para comprar uma carta
    Route::post('/loja/solicitar/{ficha_id}', [LojaController::class, 'solicitar'])->name('loja.solicitar');
    // Rota para o jogador ver o próprio inventário (Deck)
    Route::get('/meu-inventario', [InventarioController::class, 'index'])->name('inventario.index');
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    // Rota para visualizar as Fichas e o Filtro
    Route::get('/fichas', [FichaController::class, 'index'])->name('fichas.index');
    // Rotas restritas para Ficheiros (Lembrando que o Conselheiro tem passe livre automático no middleware)
    Route::middleware('patente:Ficheiro')->group(function () {
        Route::get('/categorias/criar', [CategoriaController::class, 'create'])->name('categorias.create');
        Route::post('/categorias', [CategoriaController::class, 'store'])->name('categorias.store');

        Route::get('/fichas/criar', [FichaController::class, 'create'])->name('fichas.create');
        Route::post('/fichas', [FichaController::class, 'store'])->name('fichas.store');
        Route::middleware('patente:Ficheiro')->group(function () {
        // Rotas das categorias e fichas que já estavam aqui...
        
        // Novas rotas de aprovação da loja
        Route::get('/loja/aprovacoes', [LojaController::class, 'painelAprovacao'])->name('loja.painel');
        Route::post('/loja/aprovar/{id}', [LojaController::class, 'aprovar'])->name('loja.aprovar');
        Route::post('/loja/recusar/{id}', [LojaController::class, 'recusar'])->name('loja.recusar');
    });
    });
});

Route::middleware('auth')->group(function () {
    // Rota para ver o banco e o extrato (Acesso para quem está logado)
    Route::get('/banco', [BancoController::class, 'index'])->name('banco.index');
    
    // Rota para registrar a transação (Protegida pelo middleware de patente)
    Route::post('/banco/transacao', [BancoController::class, 'store'])
        ->middleware('patente:Banqueiro')
        ->name('banco.store');
});

require __DIR__.'/auth.php';
