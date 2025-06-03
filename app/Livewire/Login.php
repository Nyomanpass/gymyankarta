<?php

namespace App\Livewire;

use Livewire\Attributes\Layout;
use Livewire\Component;


class Login extends Component
{
    #[Layout('components.layouts.auth')]
    public function render()
    {
        return view('livewire.login');
    }
}
