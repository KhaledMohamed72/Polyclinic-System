<?php

namespace Database\Seeders;

use App\Models\Doctor;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DoctorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Doctor::create([
            'clinic_id' => 1,
            'user_id' => 3,
            'title' => 'Dr',
            'degree' => 'Test degree',
            'specialist' => 'Test specialist',
            'bio' => 'Bio test',
            'fees' => 50.5,
            'slot_time' => 30
        ]);
    }
}
