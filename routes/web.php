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

    // --- PASSE DE BATALHA (Acesso Geral) ---
    Route::get('/passe', [\App\Http\Controllers\PasseController::class, 'index'])->name('passe.index');
    Route::post('/passe/missao/{missao_id}/solicitar', [\App\Http\Controllers\PasseController::class, 'solicitarVerificacao'])->name('passe.missao.solicitar');
    Route::post('/passe/comprar-premium', [\App\Http\Controllers\PasseController::class, 'comprarPremium'])->name('passe.comprarPremium');
    // --- SIMULADOR RNG ---
    Route::get('/simulador', [\App\Http\Controllers\RngController::class, 'index'])->name('rng.index');
    Route::post('/simulador/girar', [\App\Http\Controllers\RngController::class, 'girar'])->name('rng.girar');
    // --- GACHA CHIBIS (Acesso Geral) ---
    Route::get('/chibis', [\App\Http\Controllers\ChibiController::class, 'index'])->name('chibis.index');
    Route::get('/chibis/inventario', [\App\Http\Controllers\ChibiController::class, 'inventario'])->name('chibis.inventario');
    Route::post('/chibis/comprar-giro', [\App\Http\Controllers\ChibiController::class, 'comprarGiro'])->name('chibis.comprar');
    Route::post('/chibis/girar', [\App\Http\Controllers\ChibiController::class, 'girar'])->name('chibis.girar');

    // --- GACHA CHIBIS (Administração - Apenas Ficheiro/Conselheiro) ---
    Route::middleware('patente:Ficheiro')->group(function () {
        Route::post('/chibis/cadastrar', [\App\Http\Controllers\ChibiController::class, 'store'])->name('chibis.store');
        Route::delete('/chibis/excluir/{id}', [\App\Http\Controllers\ChibiController::class, 'destroy'])->name('chibis.destroy');
    });
// As rotas de view (index e inventário) e de admin (store/destroy) colocaremos junto com as views.

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

        // --- GERENCIAMENTO DO PASSE (Apenas Staff) ---
    Route::get('/admin/passes', [\App\Http\Controllers\AdminPasseController::class, 'index'])->name('admin.passes.index');
    Route::post('/admin/passes', [\App\Http\Controllers\AdminPasseController::class, 'storePasse'])->name('admin.passes.store');
    Route::post('/admin/passes/{passe_id}/nivel', [\App\Http\Controllers\AdminPasseController::class, 'storeNivel'])->name('admin.passes.nivel.store');
    Route::post('/admin/passes/{passe_id}/missao', [\App\Http\Controllers\AdminPasseController::class, 'storeMissao'])->name('admin.passes.missao.store');
    Route::get('/admin/passes/verificacoes', [\App\Http\Controllers\AdminPasseController::class, 'verificacoes'])->name('admin.passes.verificacoes');
Route::post('/admin/passes/verificacoes/{id}/aprovar', [\App\Http\Controllers\AdminPasseController::class, 'aprovarMissao'])->name('admin.passes.verificacoes.aprovar');
Route::post('/admin/passes/verificacoes/{id}/recusar', [\App\Http\Controllers\AdminPasseController::class, 'recusarMissao'])->name('admin.passes.verificacoes.recusar');
    });

    // --- ROTAS DE REGISTRO FINANCEIRO (Apenas Banqueiro) ---
    Route::post('/banco/transacao', [BancoController::class, 'store'])
         ->middleware('patente:Banqueiro')
         ->name('banco.store');
});

require __DIR__.'/auth.php';