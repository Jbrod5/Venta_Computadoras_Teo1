<?php 

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Usuario;
use App\Models\EstadoPedido;



class Pedido extends Model
{
    protected $table = 'pedido'; 
    protected $primaryKey = 'id_pedido'; 
    public $timestamps = false;

    protected $fillable = [
        'id_usuario_pedido',
        'fecha_pedido',
        'total',
        'id_estado_pedido',      
    ];




public function usuarioPedido()
    {
        return $this->belongsTo(Usuario::class, 'id_usuario', 'id_usuario');
    }

    public function cliente() {
    return $this->belongsTo(User::class, 'id_usuario_pedido');
}

public function estado() {
    return $this->belongsTo(EstadoPedido::class, 'id_estado_pedido');
}

public function detalles() {
    return $this->hasMany(PedidoDetalle::class, 'id_pedido');
}

public function ventas() {
    return $this->hasOne(Venta::class, 'id_pedido');
}
public function estadoPedido()
    {
        return $this->belongsTo(EstadoPedido::class, 'id_estado_pedido', 'id_estado_pedido');
    }

}
