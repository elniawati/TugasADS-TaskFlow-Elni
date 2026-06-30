<?php

namespace Database\Seeders;

use App\Models\Status;
use Illuminate\Database\Seeder;

class StatusSeeder extends Seeder
{
    public function run(): void
    {
        $statuses = [
            ['name' => 'To Do', 'color' => '#6c757d', 'order_position' => 1, 'is_final' => false],
            ['name' => 'In Progress', 'color' => '#0d6efd', 'order_position' => 2, 'is_final' => false],
            ['name' => 'Review', 'color' => '#fd7e14', 'order_position' => 3, 'is_final' => false],
            ['name' => 'Completed', 'color' => '#198754', 'order_position' => 4, 'is_final' => true],
            ['name' => 'Cancelled', 'color' => '#dc3545', 'order_position' => 5, 'is_final' => true],
        ];

        foreach ($statuses as $status) {
            Status::create($status);
        }
    }
}
