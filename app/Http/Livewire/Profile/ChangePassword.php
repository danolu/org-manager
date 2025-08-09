<?php

namespace App\Http\Livewire\Profile;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Livewire\Component;

class ChangePassword extends Component
{
    public $current_password;
    public $password;
    public $password_confirmation;

    protected function rules()
    {
        return [
            'current_password' => 'required',
            'password' => 'required|confirmed|string|min:6',
        ];
    }

    public function save()
    {
        $this->validate();
        $user = Auth::user();
        if (! Hash::check($this->current_password, $user->password)) {
            $this->addError('current_password', 'The provided password does not match our records.');
            return;
        }
        $user->password = Hash::make($this->password);
        $user->save();
        session()->flash('success', 'Your password has been changed successfully.');
        return redirect()->route('dashboard');
    }

    public function render()
    {
        return view('livewire.profile.change-password');
    }
}
