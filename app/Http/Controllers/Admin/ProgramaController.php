<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Programa;
use Illuminate\Http\Request;

class ProgramaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('admin.programa.index');
    }

    public function store(Request $request)
    {
        $validateData = $request->validate([
            'cod_programa' => 'required',
            'nombre_programa' => 'required',
            'area' => 'required',
        ]);

        $programa = new Programa();
        $programa->cod_programa = $validateData['cod_programa'];
        $programa->nombre_programa = $validateData['nombre_programa'];
        $programa->area = $validateData['area'];

        $programa->save();

        if ($programa){
            return redirect()->route('admin.programa.index')->with('success', 'El programa fue registrado correctamente.');
        }else {
            return redirect()->back()->withErrors('No se registro correctamente el programa.'. $programa->getMessage());
        }

    }

    public function update(Request $request, string $id)
    {
        $validateData = $request->validate([
            'cod_programa' => 'required',
            'nombre_programa' => 'required',
            'area' => 'required',
        ]);

        $programa = Programa::findOrFail($id);
        $programa->cod_programa = $validateData['cod_programa'];
        $programa->nombre_programa = $validateData['nombre_programa'];
        $programa->area = $validateData['area'];

        $programa->save();

        if ($programa){
            return redirect()->route('admin.programa.index')->with('success', 'El programa fue actualizado correctamente.');
        }else {
            return redirect()->back()->withErrors('No se actualizó correctamente el programa.'. $programa->getMessage());
        }
    }

    public function destroy(string $id)
    {
        Programa::find($id)->delete();
        return redirect()->route('admin.programa.index')->with('success', 'El programa fue eliminado correctamente.');
    }
}
