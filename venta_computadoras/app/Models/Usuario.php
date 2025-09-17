<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class Usuario extends Authenticatable
{
    protected $table = 'usuario';   // Nombre de la tabla
    protected $primaryKey = 'id_usuario'; // Clave primaria
    public $timestamps = false; 
    
    // Campos que se pueden llenar masivamente
    protected $fillable = [
        'id_tipo_usuario',
        'nombre',
        'correo',
        'pass',
        'direccion',
        'telefono'
    ];

    // Relación con tipo_usuario
    public function tipo()
    {
        return $this->belongsTo(TipoUsuario::class, 'id_tipo_usuario', 'id_tipo_usuario');
    }

    public function getAuthPassword()
    {
        return $this->pass;
    }

    public function ensamblesCreados()
    {
        return $this->hasMany(Ensamble::class, 'id_usuario_creador');
    }

    
}
