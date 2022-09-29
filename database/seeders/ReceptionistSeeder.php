<?php

namespace Database\Seeders;

use App\Models\Receptionist;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ReceptionistSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Receptionist::create([
            'clinic_id' => 1,
            'user_id' => 2,
        ]);
    }
}
