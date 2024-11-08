<?php

namespace App\Livewire\Admin;

use App\Models\Comprobante;
use App\Models\Rubro;
use App\Models\Estudiante;
use Livewire\Component;

class ComprobanteIndex extends Component
{
    public function render()
    {
        $comprobante = Comprobante::with('rubro')->get();
        $rubros = Rubro::all();

        $comprobante = Comprobante::with('estudiante')->get();
        $estudiantes = Estudiante::all();
        return view('livewire.admin.comprobante-index', compact('comprobante', 'rubros', 'estudiantes'));
    }
}