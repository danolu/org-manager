<?php

namespace Database\Seeders;

use App\Models\Setting;
use Illuminate\Database\Seeder;

class SettingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Setting::create([
            'tenure' => '2025',
            'is_election_time' => false,
            'name' => 'Organization Name',
        ]);
    }
}
