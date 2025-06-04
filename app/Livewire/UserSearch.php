<?php

namespace App\Livewire;

use App\Models\User;
use Livewire\Component;

class UserSearch extends Component
{
    public $search = '';
    public function render()
    {
        $users = User::where('name', 'like', '%' . $this->search . '%')->get();
        return view('livewire.user-search', [
            'users' => $users
        ]);
    }
}
