<?php

namespace App\Livewire\Admin;

use App\Models\Estudiante;
use App\Models\Programa;
use Livewire\Component;

class EstudianteIndex extends Component
{
    public function render()
    {
        $estudiante = Estudiante::with('programa')->get();
        $programas = Programa::all();
        return view('livewire.admin.estudiante-index', compact('estudiante', 'programas'));
    }
}
