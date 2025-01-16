<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ServiciosSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('services')->insert([
            ['name' => 'Corte de pelo con degradado', 'description' => 'Corte con degradado',
             'price' => 8.50, 'hairdresser_id' => 1],
             ['name' => 'Corte de pelo normal', 'description' => 'Corte de pelo normal',
             'price' => 6.00, 'hairdresser_id' => 1],
             ['name' => 'Arreglado de barba', 'description' => 'Arreglado de barba mediante navaja',
             'price' => 4.50, 'hairdresser_id' => 1],
        ]);
    }
}
