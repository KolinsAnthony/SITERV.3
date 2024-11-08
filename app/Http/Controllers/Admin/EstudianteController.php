<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Estudiante;
use Illuminate\Http\Request;
use App\Imports\EstudiantesImport;
use Maatwebsite\Excel\Facades\Excel;

class EstudianteController extends Controller
{

    /**
     * Display a listing of the resource.
     */
    public function importar(Request $request)
{
    $request->validate([
        'file' => 'required|mimes:xlsx,csv',
    ]);

    try {
        Excel::import(new EstudiantesImport, $request->file('file'));

        // Redirige con mensaje de éxito
        return redirect()->back()->with('success', 'Importación exitosa.');
    } catch (\Exception $e) {
        // Redirige con mensaje de error si ocurre una excepción
        return redirect()->back()->with('error', 'Error al importar (EL PROGRAMA NO EXISTE O ESTÁ ESCRITO EN LETRAS): ' . $e->getMessage());
    }
}


    public function index()
    {
        return view('admin.estudiante.index');
    }

    public function store(Request $request)
    {
        $validateData = $request->validate([
            'dni' => 'required',
            'nombre' => 'required',
            'apellido' => 'required',
            'id_programa' => 'required|exists:programas,id',
        ]);

        $estudiante = new Estudiante();
        $estudiante->dni = $validateData['dni'];
        $estudiante->nombre = $validateData['nombre'];
        $estudiante->apellido = $validateData['apellido'];
        $estudiante->id_programa = $validateData['id_programa'];

        $estudiante->save();

        if ($estudiante){
            return redirect()->route('admin.estudiante.index')->with('success', 'El estudiante fue registrado correctamente.');
        }else {
            return redirect()->back()->withErrors('No se registro correctamente al estudiante.'. $estudiante->getMessage());
        }

    }

    public function update(Request $request, string $id)
    {
        $validateData = $request->validate([
            'dni' => 'required',
            'nombre' => 'required',
            'apellido' => 'required',
            'id_programa' => 'required|exists:programas,id',
        ]);

        $estudiante = Estudiante::findOrFail($id);
        $estudiante->dni = $validateData['dni'];
        $estudiante->nombre = $validateData['nombre'];
        $estudiante->apellido = $validateData['apellido'];
        $estudiante->id_programa = $validateData['id_programa'];

        $estudiante->save();

        if ($estudiante){
            return redirect()->route('admin.estudiante.index')->with('success', 'El estudiante fue actualizado correctamente.');
        }else {
            return redirect()->back()->withErrors('No se actualizó correctamente al estudiante.'. $estudiante->getMessage());
        }
    }

    public function destroy(string $id)
    {
        Estudiante::find($id)->delete();
        return redirect()->route('admin.estudiante.index')->with('success', 'El estudiante fue eliminado correctamente.');
    }
}
