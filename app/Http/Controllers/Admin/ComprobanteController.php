<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Comprobante;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf as FacadePdf;

class ComprobanteController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function generateReport()
    {
        $comprobante = Comprobante::all();
        $pdf = FacadePdf::loadView('admin.report.filtro-reportes', compact('comprobante'));
        return $pdf->stream();
    }

    public function index()
    {
        return view('admin.comprobante.index');
    }
  

    public function store(Request $request)
    {
        $validateData = $request->validate([
            'id_estudiante' => 'required',
            'id_rubro' => 'required|exists:rubros,id',
            'estado' => 'required',
            'fecha' => 'required',
            'semestre' => 'required',
        ]);
    
        $comprobante = new Comprobante();
        $comprobante->id_estudiante = $validateData['id_estudiante'];
        $comprobante->id_rubro = $validateData['id_rubro'];
        $comprobante->estado = $validateData['estado'];
        $comprobante->fecha = $validateData['fecha'];
        $comprobante->semestre = $validateData['semestre'];
        $comprobante->precionuevo = $request->input('precionuevo', '');
        $comprobante->comentario = strtoupper($request->input('comentario', ''));
    
        $comprobante->save();
    
        if ($comprobante) {
            if ($request->input('action') === 'register_and_generate_pdf') {
                // Redirige a la ruta que genera el PDF para este comprobante con un parámetro que indica que debe refrescar la página
                return redirect()->route('admin.reports.print', ['id' => $comprobante->id, 'refresh' => true]);
            } else {
                // Redirige a la misma página con un mensaje de éxito y un parámetro que indica que debe refrescar la página
                return redirect()->route('admin.comprobante.index')
                    ->with('success', 'El comprobante fue registrado correctamente.')
                    ->with('refresh', true);
            }
            
        } else {
            // Redirige a la misma página con los errores y refresca la página
            return redirect()->back()
                ->withErrors('No se registró correctamente el comprobante.')
                ->with('refresh', true);
        }
        
    }

    

    public function update(Request $request, string $id)
    {
        $validateData = $request->validate([
            'id_estudiante' => 'nullable|exists:estudiantes,id',
            'id_rubro' => 'required|exists:rubros,id',
            'estado' => 'required',
            'fecha' => 'required',
            'semestre' => 'required',
        
        ]);

        $comprobante = Comprobante::findOrFail($id);
        if ( array_key_exists('id_estudiante', $validateData)){
            $comprobante->id_estudiante = $validateData['id_estudiante'];
        }
        $comprobante->id_rubro = $validateData['id_rubro'];
        $comprobante->estado = $validateData['estado'];
        $comprobante->fecha = $validateData['fecha'];

        $comprobante->semestre = $validateData['semestre'];

        $comprobante->save();

        if ($comprobante){
            return redirect()->route('admin.comprobante.index')->with('success', 'El comprobante fue actualizado correctamente.');
        }else {
            return redirect()->back()->withErrors('No se actualizó correctamente el comprobante.'. $comprobante->getMessage());
        }
    }

    public function destroy(string $id)
    {
        Comprobante::find($id)->delete();
        return redirect()->route('admin.comprobante.index')->with('success', 'El comprobante fue eliminado correctamente.');
    }

    
}
