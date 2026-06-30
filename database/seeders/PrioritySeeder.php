<?php

namespace Database\Seeders;

use App\Models\Priority;
use Illuminate\Database\Seeder;

class PrioritySeeder extends Seeder
{
    public function run(): void
    {
        $priorities = [
            ['name' => 'Low', 'level' => 1, 'color' => '#198754'],
            ['name' => 'Medium', 'level' => 2, 'color' => '#0dcaf0'],
            ['name' => 'High', 'level' => 3, 'color' => '#fd7e14'],
            ['name' => 'Critical', 'level' => 4, 'color' => '#dc3545'],
        ];

        foreach ($priorities as $priority) {
            Priority::create($priority);
        }
    }
}
