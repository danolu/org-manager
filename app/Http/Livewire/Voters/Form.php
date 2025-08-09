<?php

namespace App\Http\Livewire\Voters;

use App\Models\User;
use Hash;
use Livewire\Component;

class Form extends Component
{
    public $userId;
    public $name;
    public $email;
    public $user_id;
    public $category_id;
    public $phone;
    public $password;
    public $is_admin = false;

    public function mount($user = null)
    {
        $auth = auth()->user();
        if (! $auth || ! method_exists($auth, 'isAdmin') || ! $auth->isAdmin()) {
            abort(403);
        }

        if ($user instanceof User) {
            $this->userId = $user->id;
            $this->name = $user->name;
            $this->email = $user->email;
            $this->user_id = $user->user_id;
            $this->category_id = $user->category_id;
            $this->phone = $user->phone;
            $this->is_admin = $user->is_admin;
        }
    }

    protected function rules()
    {
        if ($this->userId) {
            return [
                'name' => 'required|string|max:255',
                'email' => 'required|email|unique:users,email,'.$this->userId,
                'user_id' => 'required|integer|unique:users,user_id,'.$this->userId,
                'category_id' => 'nullable|integer',
                'phone' => 'nullable|numeric|unique:users,phone,'.$this->userId,
                'is_admin' => 'nullable|boolean',
            ];
        }

        return [
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'user_id' => 'required|integer|unique:users,user_id',
            'category_id' => 'nullable|integer',
            'phone' => 'nullable|numeric|unique:users,phone',
            'password' => 'required|string|min:6',
            'is_admin' => 'nullable|boolean',
        ];
    }

    public function save()
    {
        $validated = $this->validate();
        $validated['is_admin'] = $this->is_admin ? true : false;

        if ($this->userId) {
            $user = User::findOrFail($this->userId);
            if (! empty($this->password)) {
                $this->validate(['password' => 'string|min:6']);
                $validated['password'] = Hash::make($this->password);
            }
            $user->update($validated);
            session()->flash('success', 'User updated successfully.');
        } else {
            $validated['password'] = Hash::make($this->password);
            User::create($validated);
            session()->flash('success', 'User created successfully.');
        }

        return redirect()->route('voters.index');
    }

    public function render()
    {
        return view('livewire.voters.form');
    }
}
