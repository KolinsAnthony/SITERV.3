<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Comprobante extends Model
{
    use HasFactory;
    
    
    protected $fillable = [
        'id_estudiante',
        'id_rubro',
        'estado',
        'fecha',
        'semestre',
        'comentario',
        'precionuevo'
        
    ];

    public function rubro()
    {
        return $this->belongsTo(Rubro::class, 'id_rubro');
    }

    public function estudiante()
    {
        return $this->belongsTo(Estudiante::class, 'id_estudiante');
    }

}
