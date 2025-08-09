<?php

namespace App\Http\Livewire;

use Livewire\Component;

class Dashboard extends Component
{
    public function render()
    {
        // Render the existing index view so we don't duplicate markup yet.
        return view('index');
    }
}
