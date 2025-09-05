<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Admin;
use App\Enums\Roles;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $user = Admin::firstOrCreate([
            'name' => config('app.admin.name', 'Admin'),
            'email' => config('app.admin.email', 'admin@admin.com'),
            'password' => Hash::make(config('app.admin.password', '12345678')),
        ]);

        $user->assignRole(Roles::SUPER_ADMIN->value, 'admin');
    }
}
