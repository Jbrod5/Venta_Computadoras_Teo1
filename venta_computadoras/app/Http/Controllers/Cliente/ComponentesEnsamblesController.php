<?php

namespace App\Http\Controllers\Cliente;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Ensamble;
use Illuminate\Support\Facades\Auth;

class ComponentesEnsamblesController extends Controller
{
    public function index() {
    $usuarioId = auth()->user()->id_usuario;

    $tusEnsambles = Ensamble::with('componentes')
        ->where('id_usuario_creador', $usuarioId)
        ->get();

    $predefinidos = Ensamble::with('componentes')
        ->where('predefinido', 1)
        ->get();

    $tienda = Ensamble::with('componentes')
        ->where('predefinido', 0)
        ->where('id_usuario_creador', '<>', $usuarioId)
        ->get();

    return view('cliente.ensambles', compact('tusEnsambles', 'predefinidos', 'tienda'));
}

}
