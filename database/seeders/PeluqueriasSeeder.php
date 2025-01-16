<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PeluqueriasSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('hairdressers')->insert([
            [
                'cif' => 'B12345678',
                'name' => 'Barberia Santiago',
                'phone' => '956432218',
                'address' => 'Calle Mayor, 15, 28013, Madrid',
                'owner_id' => 1, 
            ],
        ]);
    }
}
