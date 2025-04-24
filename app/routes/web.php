<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
use App\Http\Controllers\ProdutoController;
use App\Http\Controllers\ProductLogController;
use App\Http\Controllers\UsuarioController;


Route::get('/', function () {
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
});

Route::get('/dashboard', function () {
    return Inertia::render('Dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware(['auth'])->get('/produtos', function () {
    return Inertia::render('Produtos');
})->name('produtos');

Route::middleware(['auth'])->get('/produtos/novo', function () {
    return Inertia::render('EditProduto', [
        'produto' => [],
        'id'      => null,
        'user_id' => Auth::id()
    ]);
})->name('produto.novo');

Route::middleware(['auth'])->get('/usuarios', [UsuarioController::class, 'index'])->name('usuarios.index');


Route::middleware(['auth'])->group(function () {
    Route::get('/produtos/{id}/editar', [ProdutoController::class, 'editar'])->name('produtos.editar');
    Route::put('/produtos/{id}', [ProdutoController::class, 'atualizar'])->name('produtos.atualizar');
     Route::post('/products', [ProductController::class, 'store'])->name('products.store');
});

Route::middleware(['auth'])->get('/logs-produtos', [ProductLogController::class, 'index'])->name('logs.produtos');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    
});

require __DIR__.'/auth.php';
