<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TipoComponente extends Model
{
    use HasFactory;

    protected $table = 'tipo_componente';
    protected $primaryKey = 'id_tipo_componente';
    public $timestamps = false;

    public function componentes()
    {
        return $this->hasMany(Componente::class, 'id_tipo_componente', 'id_tipo_componente');
    }
}
