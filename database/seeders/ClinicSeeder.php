<?php

namespace Database\Seeders;

use App\Models\Clinic;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ClinicSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Clinic::create([
            'name' => 'itg',
            'domain' => 'itg',
            'phone' => '01128206779',
            'active' => '1',
            'type' => '0'
        ]);
    }
}
