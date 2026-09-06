<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Role;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $adminRole = Role::where('name', 'admin')->first();
        $instructorRole = Role::where('name', 'instructor')->first();
        $studentRole = Role::where('name', 'student')->first();

        // 1. Akun Admin
        User::firstOrCreate(
            ['email' => 'admin@bloom.com'],
            [
                'role_id' => $adminRole->id,
                'name' => 'Super Administrator',
                'password' => Hash::make('password123'),
                'email_verified_at' => now(),
            ]
        );

        // 2. Akun Instructor
        User::firstOrCreate(
            ['email' => 'instructor@bloom.com'],
            [
                'role_id' => $instructorRole->id,
                'name' => 'Ms. Sarah Jenkins, M.Ed.',
                'password' => Hash::make('password123'),
                'email_verified_at' => now(),
            ]
        );

        // 3. Akun Student
        User::firstOrCreate(
            ['email' => 'student@bloom.com'],
            [
                'role_id' => $studentRole->id,
                'name' => 'Budi Santoso',
                'password' => Hash::make('password123'),
                'email_verified_at' => now(),
            ]
        );
    }
}
