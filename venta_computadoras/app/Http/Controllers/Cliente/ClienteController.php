<?php

namespace App\Http\Controllers\Cliente;

use App\Http\Controllers\Controller;
use App\Models\Componente;
use App\Models\TipoComponente;

use Illuminate\Http\Request;

class ClienteController extends Controller
{
    // Esto es la vista de los componentes :3
    public function index()
    {
        $tipos = TipoComponente::with('componentes')->get();
        return view('cliente.index', compact('tipos'));
    }
}
