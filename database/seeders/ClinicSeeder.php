<?php

namespace Database\Seeders;

use App\Models\Clinic;
use App\Models\Role;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ClinicSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('super_users')->insert([
            'name' => 'super admin',
            'email' =>'superadmin@clinic.com',
            'password' => bcrypt('password')
        ]);

        $adminRole = Role::create(['name' => 'admin']);
        $recepRole = Role::create(['name' => 'recep']);
        $doctorRole = Role::create(['name' => 'doctor']);
        $patientRole = Role::create(['name' => 'patient']);
    }
}
