<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\Attributes\Layout;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;


class ResetPassword extends Component
{  
     #[Layout('components.layouts.dashboard')]
    public $old_password, $new_password, $new_password_confirmation;

    //modal
    public $isNotificationModalOpen = false;

    public function render()
    {
        if ($message = session('message')) {
            $this->isNotificationModalOpen = true;
        }   

        return view('livewire.reset-password');
    }

    public function resetPassword()
    {
        $this->validate([
            'old_password' => 'required',
            'new_password' => 'required|min:8|confirmed',
        ]);

        $user = Auth::user();

        if (!Hash::check($this->old_password, $user->password)) {
            $this->addError('old_password', 'Password lama salah.');
            return;
        }

        $user->update([
            'password' => Hash::make($this->new_password),
        ]);

        session()->flash('message', [
            'type' => 'success',
            'title' => 'Perubahan Berhasil',
            'description' => 'Password anda berhasil diubah.',
        ]);
        $this->reset(['old_password', 'new_password', 'new_password_confirmation']);
    }

    public function closeNotificationModal() {
        $this->isNotificationModalOpen = false;
    }
}
