<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\RegistroController;
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\AdminDashboardController;
use App\Http\Controllers\Admin\InventarioController;

use App\Http\Controllers\Admin\EnsambleController;
use App\Http\Controllers\PedidoController;
use App\Http\Controllers\ReporteController;
use App\Http\Controllers\CarritoController;
use App\Http\Controllers\PerfilController;


use App\Http\Controllers\Admin\UsuariosAdminController;
//use App\Http\Controllers\Admin\AdminController;

// Login
Route::get('/', function () {
    return view('welcome');
})->name('login');
// Procesar login
Route::post('/login-submit', [LoginController::class, 'login'])->name('login.submit');

// Registro de clientes
Route::get('/register', function () {
    return view('register-clients');
});
Route::post('/register', [RegistroController::class, 'store']);




// Admin
Route::middleware(['auth','role:admin'])->group(function(){
    //Route::resource('usuarios', UsuariosAdminController::class);
    Route::resource('inventario', InventarioController::class);
    Route::resource('ensambles', EnsambleController::class);
    Route::resource('pedidos', PedidoController::class);


    Route::get('reportes', [ReporteController::class, 'index']);
    
    //usuarios
    Route::get('/admin', [AdminDashboardController::class, 'dashboard'])->name('admin.dashboard');
    Route::resource('/admin/usuarios', UsuariosAdminController::class);

    //componentes - - --  - - -
     Route::get('/admin/inventario', [InventarioController::class, 'index'])->name('inventario.index');

    // Crear componente
    Route::get('/admin/inventario/create', [InventarioController::class, 'create'])->name('inventario.create');
    Route::post('/admin/inventario', [InventarioController::class, 'store'])->name('inventario.store');

    // Editar componente
    Route::get('/admin/inventario/{id}/edit', [InventarioController::class, 'edit'])->name('inventario.edit');
    Route::put('/admin/inventario/{id}', [InventarioController::class, 'update'])->name('inventario.update');

    // Movimiento de inventario (entrada, salida, ajuste)
    Route::get('/admin/inventario/{id}/movimiento', [InventarioController::class, 'movimiento'])->name('inventario.movimiento');
    Route::post('/admin/inventario/{id}/movimiento', [InventarioController::class, 'registrarMovimiento'])->name('inventario.registrarMovimiento');
    //Route::get('/admin/movimiento', [MovimientoInventarioController::class, 'create'])->name('movimiento.create');
    //Route::post('/admin/movimiento', [MovimientoInventarioController::class, 'store'])->name('movimiento.store');


    //Ensambles - - - - - - - - - --  -- - - - - - 
    Route::get ('/ensambles/create', [EnsambleController::class, 'create'])->name('ensambles.create');
    Route::post('/ensambles/store', [EnsambleController::class, 'store'])->name('ensambles.store');
    Route::get ('/ensambles/{ensamble}', [EnsambleController::class, 'show'])->name('ensambles.show');
    Route::get ('/ensambles/{ensamble}/edit', [EnsambleController::class, 'edit'])->name('ensambles.edit');
    Route::put ('/ensambles/{ensamble}', [EnsambleController::class, 'update'])->name('ensambles.update');

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


use Illuminate\Support\Facades\Auth;

Route::post('/logout', function () {
    Auth::logout();
    return redirect('/'); // o donde quieras que vaya
})->name('logout');
