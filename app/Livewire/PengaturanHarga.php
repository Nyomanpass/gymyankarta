<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\Attributes\Layout;


class PengaturanHarga extends Component
{
    #[Layout('components.layouts.dashboard')]

    public function render()
    {
        return view('livewire.pengaturan-harga');
    }
}
