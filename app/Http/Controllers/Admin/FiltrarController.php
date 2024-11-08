<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Comprobante;
use App\Models\Rubro;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;

class FiltrarController extends Controller
{
   public function procesarFormulario(Request $request)
{
    // Recibe los filtros del formulario
    $filtros = $request->input('filtros', []);

    // Recibe las fechas de inicio y fin
    $fechaInicio = $request->input('fecha_inicio');
    $fechaFin = $request->input('fecha_fin');

    // Asegurarse de que los filtros no están vacíos
    if (empty($filtros) && !$fechaInicio && !$fechaFin) {
        return redirect()->back()->with('error', 'No se seleccionaron filtros ni fechas.');
    }

    // Aplica los filtros a la consulta
    $comprobantes = Comprobante::where(function ($query) use ($filtros, $fechaInicio, $fechaFin) {
        // Filtra por estado si está en los filtros
        if (in_array('PAGADO', $filtros) || in_array('NO PAGADO', $filtros)) {
            $query->whereIn('estado', array_filter($filtros, fn($filtro) => $filtro === 'PAGADO' || $filtro === 'NO PAGADO'));
        }

        // Filtra por rubro si está en los filtros
        $rubroIds = Rubro::select('id')->whereIn('nombre_rubro', $filtros)->pluck('id')->toArray();
        if (!empty($rubroIds)) {
            $query->whereIn('id_rubro', $rubroIds);
        }

        // Filtra por semestre si está en los filtros
        $semestres = array_filter($filtros, fn($filtro) => !in_array($filtro, ['PAGADO', 'NO PAGADO']) && !in_array($filtro, Rubro::pluck('nombre_rubro')->toArray()));
        if (!empty($semestres)) {
            $query->whereIn('semestre', $semestres);
        }

        // Filtra por fecha de inicio y fin si están presentes
        if ($fechaInicio) {
            $query->where('fecha', '>=', $fechaInicio);
        }
        if ($fechaFin) {
            $query->where('fecha', '<=', $fechaFin);
        }
    })->get();

    // Crea el PDF con Dom PDF
    $pdf = PDF::loadView('admin.report.filtro-reportes', ['comprobantes' => $comprobantes]);
    return $pdf->stream();
}

}

  // ->orWhereIn('id_estudiante', function ($query) use ($filtros) { 
                                   //$query->select('id') 
                                       //  ->from('estudiantes') 
                                       //  ->join('programas', 'estudiantes.id_programa', '=', 'programas.id') 
                                        // ->whereIn('programas.nombre', $filtros); 
                              // })