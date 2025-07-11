<?php

namespace Database\Seeders;

use Illuminate\Support\Facades\DB;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SpecialiteSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('specialites')->insert([
            ['nom' => 'Cardiologue'],
            ['nom' => 'Dentiste'],
            ['nom' => 'Généraliste'],
            ['nom' => 'Dermatologue'],
        ]);
    }
}
