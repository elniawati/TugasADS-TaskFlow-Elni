<?php

namespace App\Http\Controllers;

use App\Exports\TasksExport;
use App\Http\Requests\StoreTaskRequest;
use App\Http\Requests\UpdateTaskRequest;
use App\Models\ActivityLog;
use App\Models\Category;
use App\Models\Priority;
use App\Models\Status;
use App\Models\Task;
use App\Models\TaskFile;
use App\Models\User;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;
use Maatwebsite\Excel\Facades\Excel;

class TaskController extends Controller
{
    public function index(Request $request): View
    {
        $user = Auth::user();

        $tasks = Task::query()
            ->ownedBy($user)
            ->with(['category', 'priority', 'status', 'user', 'files'])
            ->when($request->filled('search'), function ($q) use ($request) {
                $q->where('title', 'like', '%'.$request->search.'%');
            })
            ->when($request->filled('category_id'), fn ($q) => $q->where('category_id', $request->category_id))
            ->when($request->filled('priority_id'), fn ($q) => $q->where('priority_id', $request->priority_id))
            ->when($request->filled('status_id'), fn ($q) => $q->where('status_id', $request->status_id))
            ->when($request->filled('date_from'), fn ($q) => $q->whereDate('deadline', '>=', $request->date_from))
            ->when($request->filled('date_to'), fn ($q) => $q->whereDate('deadline', '<=', $request->date_to))
            ->orderBy($request->get('sort', 'deadline'), $request->get('direction', 'asc'))
            ->paginate(10)
            ->withQueryString();

        $categories = Category::all();
        $priorities = Priority::all();
        $statuses = Status::all();

        return view('tasks.index', compact('tasks', 'categories', 'priorities', 'statuses'));
    }

    public function create(): View
    {
        $categories = Category::all();
        $priorities = Priority::all();
        $statuses = Status::all();
        $users = Auth::user()->isAdmin() ? User::all() : collect();

        return view('tasks.create', compact('categories', 'priorities', 'statuses', 'users'));
    }

    public function store(StoreTaskRequest $request): RedirectResponse
    {
        $data = $request->validated();
        $data['user_id'] = Auth::user()->isAdmin() && $request->filled('user_id')
            ? $request->user_id
            : Auth::id();

        $task = Task::create($data);

        $this->storeAttachments($request, $task);

        return redirect()->route('tasks.index')->with('success', 'Task berhasil ditambahkan.');
    }

    public function show(Task $task): View
    {
        $this->authorizeAccess($task);

        $task->load(['category', 'priority', 'status', 'user', 'files.uploader', 'activityLogs.user']);

        return view('tasks.show', compact('task'));
    }

    public function edit(Task $task): View
    {
        $this->authorizeAccess($task);

        $categories = Category::all();
        $priorities = Priority::all();
        $statuses = Status::all();
        $users = Auth::user()->isAdmin() ? User::all() : collect();

        return view('tasks.edit', compact('task', 'categories', 'priorities', 'statuses', 'users'));
    }

    public function update(UpdateTaskRequest $request, Task $task): RedirectResponse
    {
        $this->authorizeAccess($task);

        $data = $request->validated();

        if (Auth::user()->isAdmin() && $request->filled('user_id')) {
            $data['user_id'] = $request->user_id;
        }

        $task->update($data);

        $this->storeAttachments($request, $task);

        return redirect()->route('tasks.index')->with('success', 'Task berhasil diperbarui.');
    }

    public function destroy(Task $task): RedirectResponse
    {
        $this->authorizeAccess($task);

        foreach ($task->files as $file) {
            Storage::disk('public')->delete($file->file_path);
        }

        $task->delete();

        return redirect()->route('tasks.index')->with('success', 'Task berhasil dihapus.');
    }

    public function updateStatus(Request $request, Task $task): RedirectResponse
    {
        $this->authorizeAccess($task);

        $request->validate(['status_id' => ['required', 'exists:statuses,id']]);

        $task->update(['status_id' => $request->status_id]);

        if ($task->status->is_final) {
            $task->update(['completed_at' => now()]);
        }

        return back()->with('success', 'Status task berhasil diperbarui.');
    }

    public function downloadFile(TaskFile $taskFile)
    {
        $this->authorizeAccess($taskFile->task);

        if (! Storage::disk('public')->exists($taskFile->file_path)) {
            abort(404, 'File tidak ditemukan.');
        }

        return Storage::disk('public')->download($taskFile->file_path, $taskFile->original_name);
    }

    public function previewFile(TaskFile $taskFile)
    {
        $this->authorizeAccess($taskFile->task);

        if (! Storage::disk('public')->exists($taskFile->file_path)) {
            abort(404, 'File tidak ditemukan.');
        }

        return Storage::disk('public')->response($taskFile->file_path, $taskFile->original_name);
    }

    public function deleteFile(TaskFile $taskFile): RedirectResponse
    {
        $this->authorizeAccess($taskFile->task);

        Storage::disk('public')->delete($taskFile->file_path);

        $task = $taskFile->task;
        $taskFile->delete();

        ActivityLog::record('deleted', "Menghapus lampiran \"{$taskFile->original_name}\"", $task);

        return back()->with('success', 'Lampiran berhasil dihapus.');
    }

    public function exportPdf(Request $request)
    {
        $tasks = $this->filteredTasksForExport($request)->get();

        $pdf = Pdf::loadView('exports.tasks-pdf', compact('tasks'))->setPaper('a4', 'landscape');

        return $pdf->download('laporan-task-'.now()->format('Y-m-d').'.pdf');
    }

    public function exportExcel(Request $request)
    {
        $tasks = $this->filteredTasksForExport($request)->get();

        return Excel::download(new TasksExport($tasks), 'laporan-task-'.now()->format('Y-m-d').'.xlsx');
    }

    private function filteredTasksForExport(Request $request)
    {
        $user = Auth::user();

        return Task::query()
            ->ownedBy($user)
            ->with(['category', 'priority', 'status', 'user'])
            ->when($request->filled('category_id'), fn ($q) => $q->where('category_id', $request->category_id))
            ->when($request->filled('priority_id'), fn ($q) => $q->where('priority_id', $request->priority_id))
            ->when($request->filled('status_id'), fn ($q) => $q->where('status_id', $request->status_id))
            ->when($request->filled('user_id') && $user->isAdmin(), fn ($q) => $q->where('user_id', $request->user_id))
            ->when($request->filled('date_from'), fn ($q) => $q->whereDate('deadline', '>=', $request->date_from))
            ->when($request->filled('date_to'), fn ($q) => $q->whereDate('deadline', '<=', $request->date_to))
            ->orderBy('deadline');
    }

    private function storeAttachments(Request $request, Task $task): void
    {
        if (! $request->hasFile('attachments')) {
            return;
        }

        foreach ($request->file('attachments') as $file) {
            $path = $file->store('task-files', 'public');

            TaskFile::create([
                'task_id' => $task->id,
                'uploaded_by' => Auth::id(),
                'original_name' => $file->getClientOriginalName(),
                'file_path' => $path,
                'file_size' => $file->getSize(),
                'mime_type' => $file->getClientMimeType(),
            ]);
        }
    }

    private function authorizeAccess(Task $task): void
    {
        if (! Auth::user()->isAdmin() && $task->user_id !== Auth::id()) {
            abort(403, 'Anda tidak memiliki akses ke task ini.');
        }
    }
}
