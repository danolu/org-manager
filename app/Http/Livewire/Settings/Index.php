<?php

namespace App\Http\Livewire\Settings;

use App\Models\Setting;
use Livewire\Component;
use Livewire\WithFileUploads;

class Index extends Component
{
    use WithFileUploads;

    public $tenure;
    public $name;
    public $logo;
    public $favicon;
    public $website;
    public $tagline;
    public $description;
    public $email;
    public $id_name;
    public $phone;
    public $address;
    public $election_start;
    public $election_end;
    public $is_election_time = false;
    public $is_registration_open = false;
    public $due_deadline;
    public $due_amount;

    public function mount()
    {
        $user = auth()->user();
        if (! $user || ! method_exists($user, 'isAdmin') || ! $user->isAdmin()) {
            abort(403, 'Unauthorized');
        }

        $settings = Setting::first();
        if ($settings) {
            $this->tenure = $settings->tenure;
            $this->name = $settings->name;
            $this->logo = $settings->logo;
            $this->favicon = $settings->favicon;
            $this->website = $settings->website;
            $this->tagline = $settings->tagline;
            $this->description = $settings->description;
            $this->email = $settings->email;
            $this->id_name = $settings->id_name;
            $this->phone = $settings->phone;
            $this->address = $settings->address;
            $this->election_start = $settings->election_start;
            $this->election_end = $settings->election_end;
            $this->is_election_time = $settings->is_election_time;
            $this->is_registration_open = $settings->is_registration_open;
            $this->due_deadline = $settings->due_deadline;
            $this->due_amount = $settings->due_amount;
        }
    }

    protected function rules()
    {
        return [
            'tenure' => 'nullable|string|max:255',
            'name' => 'nullable|string|max:255',
            'logo' => 'nullable|image|max:2048',
            'favicon' => 'nullable|image|max:1024',
            'website' => 'nullable|string|max:255',
            'tagline' => 'nullable|string|max:255',
            'description' => 'nullable|string',
            'email' => 'nullable|email|max:255',
            'id_name' => 'nullable|string|max:255',
            'phone' => 'nullable|string|max:255',
            'address' => 'nullable|string|max:255',
            'due_deadline' => 'nullable|date',
            'due_amount' => 'nullable|numeric|min:0',
            'election_start' => 'nullable|date',
            'election_end' => 'nullable|date',
            'is_election_time' => 'nullable|boolean',
            'is_registration_open' => 'nullable|boolean',
        ];
    }

    public function save()
    {
        $validated = $this->validate();

        // Handle file uploads
        if ($this->logo && is_object($this->logo)) {
            $validated['logo'] = $this->logo->store('settings', 'public');
        }
        if ($this->favicon && is_object($this->favicon)) {
            $validated['favicon'] = $this->favicon->store('settings', 'public');
        }

        $settings = Setting::first();
        if ($settings) {
            $settings->update($validated);
        } else {
            Setting::create($validated);
        }

        session()->flash('success', 'Settings updated successfully.');
    }

    public function render()
    {
        return view('livewire.settings.index');
    }
}
