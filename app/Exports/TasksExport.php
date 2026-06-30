<?php

namespace App\Exports;

use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class TasksExport implements FromCollection, WithHeadings, WithMapping, WithStyles
{
    public function __construct(private Collection $tasks) {}

    public function collection(): Collection
    {
        return $this->tasks;
    }

    public function headings(): array
    {
        return [
            'No', 'Judul', 'Pemilik', 'Kategori', 'Prioritas', 'Status', 'Deadline', 'Tanggal Dibuat',
        ];
    }

    public function map($task): array
    {
        static $no = 0;
        $no++;

        return [
            $no,
            $task->title,
            $task->user->name,
            $task->category->name,
            $task->priority->name,
            $task->status->name,
            $task->deadline->format('d-m-Y'),
            $task->created_at->format('d-m-Y H:i'),
        ];
    }

    public function styles(Worksheet $sheet): array
    {
        return [
            1 => ['font' => ['bold' => true]],
        ];
    }
}
