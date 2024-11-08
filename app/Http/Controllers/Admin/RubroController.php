<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Rubro;
use Illuminate\Http\Request;

class RubroController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('admin.rubro.index');
    }

    public function store(Request $request)
    {
        $validateData = $request->validate([
            'nombre_rubro' => 'required',
            'monto' => 'nullable|numeric',
        ]);
    
        $rubro = new Rubro();
        $rubro->nombre_rubro = $validateData['nombre_rubro'];
    
        // Verificar y formatear el monto a dos decimales
        if (!is_null($validateData['monto'])) {
            $rubro->monto = number_format((float)$validateData['monto'], 2, '.', '');
        } else {
            $rubro->monto = null;  // Permitir que el monto sea nulo si es opcional
        }
    
        $rubro->save();
    
        if ($rubro) {
            return redirect()->route('admin.rubro.index')->with('success', 'El rubro fue registrado correctamente.');
        } else {
            return redirect()->back()->withErrors('No se registró correctamente el rubro.' . $rubro->getMessage());
        }
    }
    

    public function update(Request $request, string $id)
    {
        $validateData = $request->validate([
            'nombre_rubro' => 'required',
            'monto' => 'required',
        ]);

        $rubro = Rubro::findOrFail($id);
        $rubro->nombre_rubro = $validateData['nombre_rubro'];
        $rubro->monto = $validateData['monto'];

        $rubro->save();

        if ($rubro){
            return redirect()->route('admin.rubro.index')->with('success', 'El rubro fue actualizado correctamente.');
        }else {
            return redirect()->back()->withErrors('No se actualizó correctamente el rubro.'. $rubro->getMessage());
        }
    }

    public function destroy(string $id)
    {
        Rubro::find($id)->delete();
        return redirect()->route('admin.rubro.index')->with('success', 'El rubro fue eliminado correctamente.');
    }
}
