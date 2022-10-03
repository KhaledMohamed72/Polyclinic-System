<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\Clinic;
use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // Clinic::factory(3)->has(User::factory(10))->create();

        $this->call(ClinicSeeder::class);
        $this->call(EntrustSeeder::class);
        $this->call(ReceptionistSeeder::class);
        $this->call(DoctorSeeder::class);
        $this->call(PatientSeeder::class);
        $this->call(SuperUserSeeder::class);
        $this->call(UserTypesSeeder::class);
    }
}
