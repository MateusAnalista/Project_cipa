<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::factory()
            ->count(10)
            ->create([
                'password' => Hash::make('soalegria'),
            ]);

        // Usuário Matheus
        DB::table('users')->insert([
            'name'      => 'Mateus',
            'email'     => 'mmoraes.analista@gmail.com',
            'password'  => Hash::make('soalegria'),
        ]);

        // Usuário Robert
        DB::table('users')->insert([
            'name'      => 'Robert',
            'email'     => 'robert.comunicar@gmail.com',
            'password'  => Hash::make('soalegria'),
        ]);
    }
}
