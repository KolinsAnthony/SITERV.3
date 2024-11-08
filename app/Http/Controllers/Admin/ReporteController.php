<?php 
 
namespace App\Http\Controllers\Admin; 
 
use App\Http\Controllers\Controller; 
use App\Models\Comprobante; 
use Barryvdh\DomPDF\Facade\Pdf; 
 
class ReporteController extends Controller 
{ 
    public function printReport($id) 
    { 
        // Buscar el comprobante por ID 
        $comprobante = Comprobante::findOrFail($id); 
 
        // Preparar los datos para la vista del PDF 
        $data = [ 
            'comprobante' => $comprobante, 
        ]; 
 
        // Generar el PDF usando la vista 'comprobante.blade.php' y los datos 
        $pdf = PDF::loadView('admin.report.comprobante', $data); 
 
        // Mostrar el PDF en el navegador 
        return $pdf->stream('reporte_comprobante_'.$id.'.pdf'); 
    } 
}