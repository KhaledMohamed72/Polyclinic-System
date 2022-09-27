<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UserTypesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('user_types')->insert(['type' => 'admin']);
        DB::table('user_types')->insert(['type' => 'recep']);
        DB::table('user_types')->insert(['type' => 'doctor']);
        DB::table('user_types')->insert(['type' => 'patient']);
    }
}
