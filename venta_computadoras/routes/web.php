<?php

use Illuminate\Support\Facades\Route;
Route::get('/', function () {
    return view('welcome'); //Esta será la ruta para el login :3
});




use Illuminate\Http\Request;



// Login 
use App\Http\Controllers\LoginController;
Route::post('/login', [LoginController::class, 'login']);



//Registro de clientes
use App\Http\Controllers\RegistroController;

Route::get('/register', function () {
    return view('register-clients'); // Vista con el formulario
});

Route::post('/register', [RegistroController::class, 'store']);

