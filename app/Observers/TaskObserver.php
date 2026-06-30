<?php

namespace App\Observers;

use App\Models\ActivityLog;
use App\Models\Task;

class TaskObserver
{
    public function created(Task $task): void
    {
        ActivityLog::record('created', "Membuat task \"{$task->title}\"", $task);
    }

    public function updated(Task $task): void
    {
        ActivityLog::record('updated', "Memperbarui task \"{$task->title}\"", $task);
    }

    public function deleted(Task $task): void
    {
        ActivityLog::record('deleted', "Menghapus task \"{$task->title}\"", $task);
    }
}
