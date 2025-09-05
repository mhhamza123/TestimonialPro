<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Enums\Roles;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        foreach(Roles::list() as $role) {
            \Spatie\Permission\Models\Role::updateOrCreate(
                ['name' => $role['value']],
                ['guard_name' => $role['guard']]
            );
        }
    }
}
