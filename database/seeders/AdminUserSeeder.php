<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AdminUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::create([
            'name' => 'Usuario Admin',
            'email' => 'admin@ejemplo.com',
            'password' => bcrypt('password'),
            'role' => 'admin'
        ]);      
    
        User::create([
            'name' => 'Usuario Estudiante',
            'email' => 'estudiante@ejemplo.com',
            'password' => bcrypt('estudiante_password'),
            'role' => 'student'
        ]);
    }
}
