<?php

namespace App\Livewire\Admin;

use App\Models\Rubro;
use Livewire\Component;

class RubroIndex extends Component
{
    public function render()
    {
        $rubro = Rubro::all();
        return view('livewire.admin.rubro-index', compact('rubro'));
    }
}
