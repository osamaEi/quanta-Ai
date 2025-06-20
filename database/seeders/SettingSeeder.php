<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Setting;

class SettingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Setting::create(['key' => 'site_name', 'value' => 'Quanta AI']);
        Setting::create(['key' => 'contact_email', 'value' => 'contact@quanta.ai']);
        Setting::create(['key' => 'maintenance_mode', 'value' => '0']);
    }
}
