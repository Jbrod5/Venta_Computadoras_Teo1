<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Componente extends Model
{
    protected $table = 'componente';


    protected $primaryKey = 'id_componente'; 
    public $timestamps = false; // si tienes created_at y updated_at, o false si no
    protected $fillable = [
        'id_tipo_componente',
        'nombre',
        'descripcion',
        'capacidad',
        'marca',
        'modelo',
        'precio',
        'cantidad_stock'
    ];

    public function tipo()
    {
        return $this->belongsTo(TipoComponente::class, 'id_tipo_componente');
    }

     public function ensambles()
    {
        return $this->belongsToMany(Ensamble::class, 'componente_ensamble', 'id_componente', 'id_ensamble');
    }
    public function tipoComponente()
{
    return $this->belongsTo(TipoComponente::class, 'id_tipo_componente');
}

}
