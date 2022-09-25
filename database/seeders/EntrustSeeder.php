<?php

namespace Database\Seeders;

use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Seeder;

class EntrustSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $adminRole = Role::create(['name' => 'admin']);
        $recepRole = Role::create(['name' => 'recep']);
        $patientRole = Role::create(['name' => 'patient']);

        $admin = User::create(['clinic_id' => 1, 'name' => 'admin', 'email' => 'admin@clinic.com', 'password' => bcrypt(123123123)]);
        $admin->attachRole($adminRole);
        $receptionist = User::create(['clinic_id' => 1, 'name' => 'receptionist', 'email' => 'receptionist@clinic.com', 'password' => bcrypt(123123123)]);
        $receptionist->attachRole($recepRole);
        $patient = User::create(['clinic_id' => 1, 'name' => 'patient', 'email' => 'patient@clinic.com', 'password' => bcrypt(123123123)]);
        $patient->attachRole($patientRole);
    }
}
