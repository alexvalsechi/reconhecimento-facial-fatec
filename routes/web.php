<?php

use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\RegistroController;
use App\Http\Controllers\UsuarioController;
use App\Models\Registro;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

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

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth'])->name('dashboard');

Route::middleware(['web', \App\Http\Middleware\AutenticarUsuarioAdmin::class])->group(function () {
    route::get('/usuario', [UsuarioController::class, 'index']);
    route::post('/salvar/usuario', [UsuarioController::class, 'salvar']);
});
Route::middleware(['web'])->group(function () {
    Route::get('/registro-ponto',[RegistroController::class, 'index'])->name('registro');
    Route::post('/registrar-ponto',[RegistroController::class, 'registrar'])->name('registrar');
    Route::get('/listagem-ponto', [RegistroController::class, 'listar_pag']);
    Route::get('/listar/ponto', [RegistroController::class, 'listar'])->name('listar');
    Route::get('/sair', [AuthenticatedSessionController::class, 'destroy'])
                ->name('sair');
    Route::get('/edit/ponto/{registro}', [RegistroController::class, 'edit']);
    Route::post('/update/ponto/{registro}', [RegistroController::class, 'update']);
});
require __DIR__.'/auth.php';
