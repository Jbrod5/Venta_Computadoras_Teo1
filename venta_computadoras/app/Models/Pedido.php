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


public function estadoPedido() {
    return $this->belongsTo(EstadoPedido::class, 'id_estado_pedido');
}

public function usuarioPedido()
    {
        return $this->belongsTo(Usuario::class, 'id_usuario', 'id_usuario');
    }

}
