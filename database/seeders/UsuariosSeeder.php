<?php

namespace Database\Seeders;

use Carbon\Carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UsuariosSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('users')->insert([
            [
                'dni' => '12345678A',
                'name' => 'Santiago Rosado Ruiz',
                'sex' => 'masculino',
                'email' => 'santiago@gmail.com',
                'phone'=> '665613319',
                'password' => Hash::make('Tomelloso96$'),
                'role' => 'propietario',
                'email_verified_at' => Carbon::now(), 
            ],
            [
                'dni' => '87654321A',
                'name' => 'Pablo Jiménez Bodalo',
                'sex' => 'masculino',
                'email' => 'pablo@gmail.com',
                'phone'=> '665613317',
                'password' => Hash::make('Tomelloso96$'),
                'role' => 'cliente',
                'email_verified_at' => Carbon::now(), 
            ],
            [
                'dni' => '98765432C',
                'name' => 'Miguel Torres Sánchez',
                'sex' => 'masculino',
                'email' => 'miguel@gmail.com',
                'phone' => '665613319',
                'password' => Hash::make('Tomelloso96$'),
                'role' => 'cliente',
                'email_verified_at' => Carbon::now(),
            ],
            [
                'dni' => '87654322D',
                'name' => 'David Ruiz Gómez',
                'sex' => 'masculino',
                'email' => 'david@gmail.com',
                'phone' => '665613320',
                'password' => Hash::make('Tomelloso96$'),
                'role' => 'cliente',
                'email_verified_at' => Carbon::now(),
            ],
            [
                'dni' => '87654323E',
                'name' => 'Álvaro Fernández Pérez',
                'sex' => 'masculino',
                'email' => 'alvaro@gmail.com',
                'phone' => '665613321',
                'password' => Hash::make('Tomelloso96$'),
                'role' => 'cliente',
                'email_verified_at' => Carbon::now(),
            ],
        ]);
    }
}
