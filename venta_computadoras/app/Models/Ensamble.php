<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Ensamble extends Model
{
    protected $table = 'ensamble';           
    protected $primaryKey = 'id_ensamble';   
    public $timestamps = false; 

    protected $fillable = [
        'predefinido',
        'id_usuario_creador'
    ];

    // Relación con el usuario creador
    public function usuarioCreador()
    {
        return $this->belongsTo(Usuario::class, 'id_usuario_creador');
    }

    // Relación con componentes
    public function componentes()
    {
        return $this->belongsToMany(Componente::class, 'componente_ensamble', 'id_ensamble', 'id_componente');
    }
}
