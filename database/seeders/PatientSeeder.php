<?php

namespace Database\Seeders;

use App\Models\Patient;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PatientSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Patient::create([
            'clinic_id' => 1,
            'user_id' => 4,
            'doctor_id' => 3,
            'receptionist_id' => 2,
            'gender' => 'male',
            'age' => 22
        ]);
    }
}
