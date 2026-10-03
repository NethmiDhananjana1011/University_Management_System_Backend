<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class RoleSeeder extends Seeder
{
    public function run(): void
    {
        // ප්‍රධාන Roles 3 නිර්මාණය කිරීම
        Role::create(['name' => 'admin']);
        Role::create(['name' => 'student']);
        Role::create(['name' => 'lecturer']);
    }
}