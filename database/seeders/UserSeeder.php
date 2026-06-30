<?php

namespace Database\Seeders;

use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        $adminRole = Role::where('name', 'admin')->first();
        $userRole = Role::where('name', 'user')->first();

        User::create([
            'name' => 'Administrator',
            'email' => 'admin@taskflow.test',
            'password' => Hash::make('password'),
            'role_id' => $adminRole->id,
            'email_verified_at' => now(),
        ]);

        User::create([
            'name' => 'Budi Santoso',
            'email' => 'user@taskflow.test',
            'password' => Hash::make('password'),
            'role_id' => $userRole->id,
            'email_verified_at' => now(),
        ]);

        User::create([
            'name' => 'Siti Aminah',
            'email' => 'siti@taskflow.test',
            'password' => Hash::make('password'),
            'role_id' => $userRole->id,
            'email_verified_at' => now(),
        ]);
    }
}
