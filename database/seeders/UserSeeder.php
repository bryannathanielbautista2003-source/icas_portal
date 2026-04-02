<?php

namespace Database\Seeders; // <--- Check this spelling carefully!

use Illuminate\Database\Seeder;
use App\Models\User;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        // Create Admin
        User::create([
            'name'     => 'System Admin',
            'email'    => 'admin@school.edu',
            'password' => 'password123',
            'role'     => 'admin',
        ]);

        // Create Faculty
        User::create([
            'name'     => 'Professor Smith',
            'email'    => 'faculty@school.edu',
            'password' => 'password123',
            'role'     => 'faculty',
        ]);

        // Create Student
        User::create([
            'name'     => 'John Doe',
            'email'    => 'student@school.edu',
            'password' => 'password123',
            'role'     => 'student',
        ]);
    }
}