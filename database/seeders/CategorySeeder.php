<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    public function run(): void
    {
        $categories = [
            ['name' => 'Pengembangan', 'color' => '#0d6efd', 'description' => 'Tugas terkait pengembangan perangkat lunak'],
            ['name' => 'Desain', 'color' => '#6610f2', 'description' => 'Tugas terkait desain UI/UX'],
            ['name' => 'Marketing', 'color' => '#d63384', 'description' => 'Tugas terkait pemasaran'],
            ['name' => 'Administrasi', 'color' => '#fd7e14', 'description' => 'Tugas administratif'],
            ['name' => 'Riset', 'color' => '#198754', 'description' => 'Tugas riset dan analisis'],
        ];

        foreach ($categories as $category) {
            Category::create($category);
        }
    }
}
