<?php

namespace Database\Seeders;

use App\Models\Role;
use Illuminate\Database\Seeder;

class RoleSeeder extends Seeder
{
    public function run(): void
    {
        Role::insert([
            ['name' => 'admin', 'label' => 'Administrator', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'user', 'label' => 'User', 'created_at' => now(), 'updated_at' => now()],
        ]);
    }
}
