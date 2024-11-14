<?php

namespace Database\Seeders;

use App\Models\Role;
use Illuminate\Database\Seeder;

class RoleSeeder extends Seeder
{
    public function run(): void
    {
        $roles = ['user', 'master admin', 'developer', 'HR'];

        foreach ($roles as $role) {
            Role::firstOrCreate(['role' => $role]);
        }
    }
}
