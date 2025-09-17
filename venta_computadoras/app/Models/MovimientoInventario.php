<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MovimientoInventario extends Model
{
    protected $table = 'movimiento_inventario';
    protected $primaryKey = 'id_movimiento';
    public $timestamps = false; // porque tu tabla usa "fecha" en lugar de updated_at/created_at

    protected $fillable = [
        'id_componente',
        'id_tipo_movimiento',
        'cantidad',
        'id_usuario',
        'observacion',
    ];

    public function componente()
    {
        return $this->belongsTo(Componente::class, 'id_componente');
    }

    public function tipoMovimiento()
    {
        return $this->belongsTo(TipoMovimientoInventario::class, 'id_tipo_movimiento');
    }

    public function usuario()
    {
        return $this->belongsTo(Usuario::class, 'id_usuario');
    }


}
