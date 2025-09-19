<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class HistorialCambiosPedido extends Model
{

    protected $table = 'historial_cambios_pedido';

    // Campos que se pueden asignar masivamente
    protected $fillable = [
        'id_pedido',
        'id_estado_pedido',
        'descripcion',   
        'estado_anterior',
        'estado_nuevo'
    ];


    public $timestamps = false;





    public function pedido() {
    return $this->belongsTo(Pedido::class, 'id_pedido');
}

public function estado() {
    return $this->belongsTo(EstadoPedido::class, 'id_estado_pedido');
}
}
