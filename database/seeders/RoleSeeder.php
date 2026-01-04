<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        \App\Models\User::create([
            'name' => 'Bendahara Utama',
            'email' => 'bendahara@mail.com',
            'password' => \Illuminate\Support\Facades\Hash::make('password'),
            'role' => 'bendahara',
            'is_active' => true,
        ]);
    }
}
