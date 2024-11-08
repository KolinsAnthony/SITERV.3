<?php 
namespace App\Imports; 
use App\Models\Estudiante; 
use Maatwebsite\Excel\Concerns\ToModel; 

class EstudiantesImport implements ToModel 
{ 
    public function model(array $row) 
    { 
        return new Estudiante([ 
            'dni'        => $row[0],  // Primera columna del archivo 
            'nombre'     => strtoupper($row[1]),  // Convertir nombre a mayúsculas
            'apellido'   => strtoupper($row[2]),  // Convertir apellido a mayúsculas
            'id_programa' => $row[3],  // Cuarta columna del archivo 
        ]); 
    } 
}