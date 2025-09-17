<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Venta extends Model
{
    protected $table = 'venta';
    protected $primaryKey = 'id_venta';
    public $timestamps = false;

    // Relación con Usuario (Ensamblador)
    public function usuarioEnsamblador()
    {
        return $this->belongsTo(Usuario::class, 'id_usuario_ensamblador');
    }

    // Relación con Pedido
    public function pedido()
    {
        return $this->hasOne(Pedido::class, 'id_pedido');
    }
}
