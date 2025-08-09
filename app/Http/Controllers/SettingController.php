<?php

namespace App\Http\Controllers;

use App\Models\Setting;
use Illuminate\Http\Request;

class SettingController extends Controller
{
    public function index()
    {
        $settings = Setting::first();

        return view('settings', compact('settings'));
    }

    public function store(Request $request)
    {
        $user = $request->user();

        if (! $user->is_admin) {
            return redirect()->route('settings.index')
                ->with('error', 'You do not have permission to update settings.');
        }

        $adminFields = [
            'election_start',
            'election_end',
            'is_election_time',
            'tenure',
            'name',
            'logo',
            'favicon',
            'website',
            'tagline',
            'description',
            'email',
            'id_name',
            'phone',
            'address',
            'is_registration_open',
        ];

       
            $validationRules = [
                'tenure' => 'nullable|string|max:255',
                'name' => 'nullable|string|max:255',
                'logo' => 'nullable|string|max:255',
                'favicon' => 'nullable|string|max:255',
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

        $validated = $request->validate($validationRules);

        $dataToUpdate = array_intersect_key($validated, array_flip($adminFields));

        $settings = Setting::first();

        if ($settings) {
            $settings->update($dataToUpdate);
        } else {
            $settings = Setting::create($dataToUpdate);
        }

        return redirect()->route('settings.index')->with('success', 'Settings updated successfully.');
    }
}
