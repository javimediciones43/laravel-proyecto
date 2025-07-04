<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class Admin2UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::create([
            'name' => 'Usuario Admin2',
            'email' => 'admin@roberto.com',
            'password' => bcrypt('admin'),
            'role' => 'admin'
        ]);
    }
}
