<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Priority;
use App\Models\Status;
use App\Models\Task;
use App\Models\User;
use Illuminate\Database\Seeder;

class TaskSeeder extends Seeder
{
    public function run(): void
    {
        $users = User::where('role_id', '!=', 1)->get();
        $categories = Category::all();
        $priorities = Priority::all();
        $statuses = Status::all();

        $titles = [
            'Membuat desain landing page',
            'Memperbaiki bug login',
            'Menyusun laporan bulanan',
            'Riset kompetitor produk',
            'Optimasi query database',
            'Membuat konten media sosial',
            'Review kode tim backend',
            'Menyusun dokumentasi API',
            'Testing fitur pembayaran',
            'Mempersiapkan presentasi klien',
        ];

        foreach ($titles as $index => $title) {
            Task::create([
                'user_id' => $users->random()->id,
                'category_id' => $categories->random()->id,
                'priority_id' => $priorities->random()->id,
                'status_id' => $statuses->random()->id,
                'title' => $title,
                'description' => 'Deskripsi lengkap untuk tugas: '.$title,
                'notes' => null,
                'deadline' => now()->addDays(rand(-5, 20)),
            ]);
        }
    }
}
