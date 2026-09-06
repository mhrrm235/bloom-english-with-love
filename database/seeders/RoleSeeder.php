<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Role;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $roles = [
            [
                'name' => 'admin',
                'display_name' => 'Administrator',
                'description' => 'Akses penuh untuk mengelola seluruh sistem, user, webinar, dan course.',
            ],
            [
                'name' => 'instructor',
                'display_name' => 'Instructor / Pengajar',
                'description' => 'Akses untuk membuat, memperbarui, dan mengelola materi course serta webinar.',
            ],
            [
                'name' => 'student',
                'display_name' => 'Student / Peserta',
                'description' => 'Akses untuk mendaftar webinar, mengakses link webinar, dan belajar materi course.',
            ],
        ];

        foreach ($roles as $roleData) {
            Role::firstOrCreate(['name' => $roleData['name']], $roleData);
        }
    }
}
