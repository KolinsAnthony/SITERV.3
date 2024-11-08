<?php

namespace App\Livewire\Admin;

use App\Models\User;
use Livewire\Component;
use Spatie\Permission\Models\Role;

class UserIndex extends Component
{
    public function render()
    {
        $users = User::all();
        $roles = Role::all();
        return view('livewire.admin.user-index', compact('users', 'roles'));
    }
}