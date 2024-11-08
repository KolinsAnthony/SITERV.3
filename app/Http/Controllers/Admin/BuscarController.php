<?php 
 
namespace App\Http\Controllers\Admin; 
 
use App\Http\Controllers\Controller; 
use App\Models\Estudiante; 
use Illuminate\Http\Request; 
 
class BuscarController extends Controller 
{ 
    public function buscarEstudiante($dni) 
    { 
        $estudiante = Estudiante::where('dni', $dni)->first(); 
 
        if ($estudiante) { 
            return response()->json([ 
                'id' => $estudiante->id,
                'nombreCompleto' => $estudiante->nombre . ' ' . $estudiante->apellido, 
                'nombrePrograma' => $estudiante->programa->nombre_programa, 
            ]); 
        } else { 
            return response()->json([ 
                'error' => 'Estudiante no encontrado' 
            ], 404); 
        } 
    } 
}