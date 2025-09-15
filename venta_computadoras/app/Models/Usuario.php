<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Usuario extends Model
{
    protected $table = 'usuario';   // Nombre de la tabla
    protected $primaryKey = 'id_usuario'; // Clave primaria

    // Campos que se pueden llenar masivamente
    protected $fillable = [
        'id_tipo_usuario',
        'nombre',
        'correo',
        'pass',
        'direccion',
        'telefono'
    ];

    public $timestamps = false; 
}
