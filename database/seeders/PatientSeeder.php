<?php

namespace Database\Seeders;

use App\Models\Patient;
use App\Models\User;
use Faker\Factory as Faker;
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
        $faker = Faker::create();
        for ($i = 1; $i <= 1000; $i++) {
            User::create([
                'id' => $i,
                'clinic_id' => 1,
                'name' => $faker->userName,
                'email' => $faker->email,
                'password' => $faker->password(8),

            ]);
            Patient::create([
                'clinic_id' => 1,
                'user_id' => $i,
                'doctor_id' => 3,
                'receptionist_id' => 2,
                'gender' => 'male',
                'age' => $faker->randomNumber(20,100)
            ]);
        }
    }
}
