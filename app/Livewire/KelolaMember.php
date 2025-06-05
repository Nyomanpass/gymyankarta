<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\Attributes\Layout;

class KelolaMember extends Component
{

    #[Layout('components.layouts.dashboard')]
    public function render()
    {
        return view('livewire.kelola-member');
    }
}
