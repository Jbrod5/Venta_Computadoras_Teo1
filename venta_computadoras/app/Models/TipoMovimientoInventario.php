<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TipoMovimientoInventario extends Model
{
    protected $table = 'tipo_movimiento_inventario';
    protected $primaryKey = 'id_tipo_movimiento';
    public $timestamps = false;

    protected $fillable = ['tipo_movimiento'];
}
