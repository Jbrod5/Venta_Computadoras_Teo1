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
//use App\Http\Controllers\CarritoController;
use App\Http\Controllers\PerfilController;


use App\Http\Controllers\Admin\UsuariosAdminController;

use App\Http\Controllers\Cliente\ClienteController;
use App\Http\Controllers\Cliente\CarritoController;
use App\Http\Controllers\Cliente\ComponentesEnsamblesController;
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
Route::middleware(['auth','role:admin'])->prefix('admin')->group(function(){

    // Dashboard
    Route::get('/', [AdminDashboardController::class, 'dashboard'])->name('admin.dashboard');

    // Usuarios
    Route::resource('usuarios', UsuariosAdminController::class);

    // Inventario
    Route::resource('inventario', InventarioController::class);
    Route::get('inventario/{id}/movimiento', [InventarioController::class, 'movimiento'])->name('inventario.movimiento');
    Route::post('inventario/{id}/movimiento', [InventarioController::class, 'registrarMovimiento'])->name('inventario.registrarMovimiento');

    // Ensambles
    Route::resource('ensambles', EnsambleController::class) ;

    // Pedidos
    Route::resource('pedidos', PedidoController::class);

    // Reportes
    Route::get('reportes', [ReporteController::class, 'index'])->name('admin.reportes.index');
});






// Técnico
Route::middleware(['auth','role:tecnico'])->group(function(){
    Route::get('ensambles/tecnico', [EnsambleController::class, 'verEnsamble']);
    Route::post('pedidos/actualizar', [PedidoController::class, 'actualizarEstado']);
});




// Cliente
Route::middleware(['auth','role:cliente'])->group(function(){
    Route::get('/inicio', [ClienteController::class, 'index']) ->name('cliente.index');
    //Route::get('/componentes', [\App\Http\Controllers\Cliente\ClienteComponenteController::class, 'index'])->name('cliente.componentes.index'); // componentes :3


    //Route::get('/ensambles', [ClienteController::class, 'index']) ->name('cliente.ensambles');


    Route::get('/componentes', [ComponentesEnsamblesController::class, 'index'])->name('cliente.componentes.index');




    Route::get('/carrito', [CarritoController::class, 'index'])->name('carrito.index');

   //  Agregar al carrito 
    Route::post('/carrito/agregar/componente/{id}', [CarritoController::class, 'agregarComponente'])->name('carrito.agregar.componente');
    Route::post('/carrito/agregar/ensamble/{id}', [CarritoController::class, 'agregarEnsamble'])->name('carrito.agregar.ensamble');

    Route::get('/mispedidos', [ClienteController::class, 'index']) ->name('cliente.pedidos');


    Route::post('carrito/agregar', [CarritoController::class, 'agregar']);
    Route::post('carrito/confirmar', [CarritoController::class, 'confirmar']);
    Route::get('perfil', [PerfilController::class, 'index']);


    // Actualizar cantidad
    Route::post('/carrito/actualizar/componente/{id}', [CarritoController::class, 'actualizarComponente'])->name('carrito.actualizar.componente');
    Route::post('/carrito/actualizar/ensamble/{id}', [CarritoController::class, 'actualizarEnsamble'])->name('carrito.actualizar.ensamble');

    // Eliminar
    Route::post('/carrito/eliminar/componente/{id}', [CarritoController::class, 'eliminarComponente'])->name('carrito.eliminar.componente');
    Route::post('/carrito/eliminar/ensamble/{id}', [CarritoController::class, 'eliminarEnsamble'])->name('carrito.eliminar.ensamble');

    // Confirmar compra
    Route::post('/carrito/confirmar', [CarritoController::class, 'confirmar'])->name('carrito.confirmar');




    //Ensambles:
    Route::get('/ensambles', [ComponentesEnsamblesController::class, 'index'])->name('cliente.ensambles.index');
    Route::get('/ensambles/crear', [ComponentesEnsamblesController::class, 'create'])->name('cliente.ensambles.create');
});


use Illuminate\Support\Facades\Auth;

Route::post('/logout', function () {
    Auth::logout();
    return redirect('/'); // o donde quieras que vaya
})->name('logout');
