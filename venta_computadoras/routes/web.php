<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\RegistroController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\InventarioController;
use App\Http\Controllers\EnsambleController;
use App\Http\Controllers\PedidoController;
use App\Http\Controllers\ReporteController;
use App\Http\Controllers\CarritoController;
use App\Http\Controllers\PerfilController;


use App\Http\Controllers\Admin\UsuariosAdminController;

// Login
Route::get('/', function () {
    return view('welcome');
})->name('login');
Route::post('/login', [LoginController::class, 'login']);

// Registro de clientes
Route::get('/register', function () {
    return view('register-clients');
});
Route::post('/register', [RegistroController::class, 'store']);




// Admin
Route::middleware(['auth','role:admin'])->group(function(){
    Route::resource('usuarios', UsuariosAdminController::class);
    Route::resource('inventario', InventarioController::class);
    Route::resource('ensambles', EnsambleController::class);
    Route::resource('pedidos', PedidoController::class);
    Route::get('reportes', [ReporteController::class, 'index']);
});

// Técnico
Route::middleware(['auth','role:tecnico'])->group(function(){
    Route::get('ensambles/tecnico', [EnsambleController::class, 'verEnsamble']);
    Route::post('pedidos/actualizar', [PedidoController::class, 'actualizarEstado']);
});

// Cliente
Route::middleware(['auth','role:cliente'])->group(function(){
    Route::get('catalogo', [CarritoController::class, 'index']);
    Route::post('carrito/agregar', [CarritoController::class, 'agregar']);
    Route::post('carrito/confirmar', [CarritoController::class, 'confirmar']);
    Route::get('perfil', [PerfilController::class, 'index']);
});
