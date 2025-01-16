<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AltaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('signups')->insert([
            ['client_id' => 2, 'hairdresser_id' => 1],
            ['client_id' => 3, 'hairdresser_id' => 1],
            ['client_id' => 4, 'hairdresser_id' => 1],
            ['client_id' => 5, 'hairdresser_id' => 1],
            
        ]);
    }
}
