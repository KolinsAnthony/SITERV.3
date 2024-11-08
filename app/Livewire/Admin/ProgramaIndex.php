<?php

namespace App\Livewire\Admin;

use App\Models\Programa;
use Livewire\Component;

class ProgramaIndex extends Component
{
    public function render()
    {
        $programa = Programa::all();
        return view('livewire.admin.programa-index', compact('programa'));
    }
}
