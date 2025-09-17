<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\StockController;


Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::middleware(['auth'])->group(function () {
    // Rota para a API de busca dinâmica de ações
    Route::get('/api/search-stocks', [StockController::class, 'search'])->name('stocks.search');
    
    // Rota para a página de consulta (exibe o formulário)
    Route::get('/consultar', [StockController::class, 'showConsultaForm'])->name('stocks.consulta.form');

    // Rota para processar a consulta (POST do formulário)
    Route::post('/consultar', [StockController::class, 'consultar'])->name('stocks.consultar');
});

Route::middleware(['auth'])->group(function () {
    // ... rotas de consulta

    // Rota para a página de compra (exibe o formulário)
    Route::get('/comprar', [StockController::class, 'showCompraForm'])->name('stocks.compra.form');

    // Rota para processar a compra (POST do formulário)
    Route::post('/comprar', [StockController::class, 'comprar'])->name('stocks.comprar');
});

Route::middleware(['auth'])->group(function () {
    // ... rotas de consulta e compra

    // Rota para a página de venda (exibe o formulário)
    Route::get('/vender', [StockController::class, 'showVendaForm'])->name('stocks.venda.form');

    // Rota para processar a venda (POST do formulário)
    Route::post('/vender', [StockController::class, 'vender'])->name('stocks.vender');
});


Route::middleware(['auth'])->group(function () {
    // ... rotas de consulta, compra e venda

    // Rota para a página de histórico de transações
    Route::get('/historico', [StockController::class, 'showHistorico'])->name('stocks.historico');
});

require __DIR__ . '/auth.php';