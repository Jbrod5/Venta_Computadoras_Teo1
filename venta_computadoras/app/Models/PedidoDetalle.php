<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PedidoDetalle extends Model
{
    protected $table = 'pedido_detalle';
    protected $primaryKey = 'id_detalle';
    public $timestamps = false;

    protected $fillable = [
        'id_pedido',
        'id_componente',
        'id_ensamble',
        'cantidad',
    ];

    // Relaciones correctas:
    public function componente()
    {
        return $this->belongsTo(Componente::class, 'id_componente', 'id_componente');
    }

    public function ensamble()
    {
        return $this->belongsTo(Ensamble::class, 'id_ensamble', 'id_ensamble');
    }

    public function pedido()
    {
        return $this->belongsTo(Pedido::class, 'id_pedido', 'id_pedido');
    }
}
