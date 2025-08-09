<?php

namespace App\Http\Livewire\Profile;

use Livewire\Component;
use Illuminate\Support\Facades\Auth;

class Edit extends Component
{
    public $phone;

    public function mount()
    {
        $this->phone = Auth::user()->phone;
    }

    protected function rules()
    {
        return [
            'phone' => 'required|numeric',
        ];
    }

    public function save()
    {
        $this->validate();
        $user = Auth::user();
        $user->phone = $this->phone;
        $user->save();
        session()->flash('success', 'Profile updated');
        return redirect()->route('dashboard');
    }

    public function render()
    {
        return view('livewire.profile.edit');
    }
}
