@extends('layouts.app')
@section('title', 'Task')

@section('content')
<div class="card p-3 p-md-4">
    <div class="d-flex flex-wrap justify-content-between align-items-center mb-3 gap-2">
        <h5 class="mb-0"><i class="bi bi-list-task me-1"></i> Daftar Task</h5>
        <div class="d-flex gap-2">
            <a href="{{ route('tasks.export.pdf', request()->query()) }}" class="btn btn-outline-danger btn-sm"><i class="bi bi-file-earmark-pdf"></i> PDF</a>
            <a href="{{ route('tasks.export.excel', request()->query()) }}" class="btn btn-outline-success btn-sm"><i class="bi bi-file-earmark-excel"></i> Excel</a>
            <a href="{{ route('tasks.create') }}" class="btn btn-primary btn-sm"><i class="bi bi-plus-lg"></i> Tambah Task</a>
        </div>
    </div>

    <form method="GET" class="row g-2 mb-3">
        <div class="col-md-3">
            <input type="text" name="search" class="form-control form-control-sm" placeholder="Cari judul task..." value="{{ request('search') }}">
        </div>
        <div class="col-md-2">
            <select name="category_id" class="form-select form-select-sm">
                <option value="">Semua Kategori</option>
                @foreach($categories as $category)
                    <option value="{{ $category->id }}" {{ request('category_id') == $category->id ? 'selected' : '' }}>{{ $category->name }}</option>
                @endforeach
            </select>
        </div>
        <div class="col-md-2">
            <select name="priority_id" class="form-select form-select-sm">
                <option value="">Semua Prioritas</option>
                @foreach($priorities as $priority)
                    <option value="{{ $priority->id }}" {{ request('priority_id') == $priority->id ? 'selected' : '' }}>{{ $priority->name }}</option>
                @endforeach
            </select>
        </div>
        <div class="col-md-2">
            <select name="status_id" class="form-select form-select-sm">
                <option value="">Semua Status</option>
                @foreach($statuses as $status)
                    <option value="{{ $status->id }}" {{ request('status_id') == $status->id ? 'selected' : '' }}>{{ $status->name }}</option>
                @endforeach
            </select>
        </div>
        <div class="col-md-2">
            <input type="date" name="date_from" class="form-control form-control-sm" value="{{ request('date_from') }}" title="Dari tanggal">
        </div>
        <div class="col-md-1">
            <button class="btn btn-sm btn-outline-secondary w-100"><i class="bi bi-search"></i></button>
        </div>
    </form>

    <div class="table-responsive">
        <table class="table table-hover align-middle">
            <thead>
                <tr>
                    <th><a href="{{ request()->fullUrlWithQuery(['sort' => 'title', 'direction' => request('direction') == 'asc' ? 'desc' : 'asc']) }}" class="text-decoration-none text-dark">Judul <i class="bi bi-arrow-down-up small"></i></a></th>
                    @if(auth()->user()->isAdmin())<th>Pemilik</th>@endif
                    <th>Kategori</th>
                    <th>Prioritas</th>
                    <th>Status</th>
                    <th><a href="{{ request()->fullUrlWithQuery(['sort' => 'deadline', 'direction' => request('direction') == 'asc' ? 'desc' : 'asc']) }}" class="text-decoration-none text-dark">Deadline <i class="bi bi-arrow-down-up small"></i></a></th>
                    <th>Lampiran</th>
                    <th class="text-end">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($tasks as $task)
                    <tr>
                        <td>
                            <a href="{{ route('tasks.show', $task) }}" class="text-decoration-none fw-medium">{{ $task->title }}</a>
                            @if($task->isOverdue())
                                <span class="badge bg-danger-subtle text-danger-emphasis ms-1">Overdue</span>
                            @endif
                        </td>
                        @if(auth()->user()->isAdmin())<td>{{ $task->user->name }}</td>@endif
                        <td><span class="badge badge-soft" style="background-color: {{ $task->category->color }}22; color: {{ $task->category->color }};">{{ $task->category->name }}</span></td>
                        <td><span class="badge badge-soft" style="background-color: {{ $task->priority->color }}22; color: {{ $task->priority->color }};">{{ $task->priority->name }}</span></td>
                        <td>
                            <form action="{{ route('tasks.status', $task) }}" method="POST">
                                @csrf @method('PATCH')
                                <select name="status_id" class="form-select form-select-sm" onchange="this.form.submit()" style="min-width:130px;">
                                    @foreach($statuses as $status)
                                        <option value="{{ $status->id }}" {{ $task->status_id == $status->id ? 'selected' : '' }}>{{ $status->name }}</option>
                                    @endforeach
                                </select>
                            </form>
                        </td>
                        <td>{{ $task->deadline->format('d M Y') }}</td>
                        <td>
                            @if($task->files->count())
                                <span class="badge bg-secondary-subtle text-secondary-emphasis"><i class="bi bi-paperclip"></i> {{ $task->files->count() }}</span>
                            @else
                                <span class="text-secondary small">-</span>
                            @endif
                        </td>
                        <td class="text-end">
                            <a href="{{ route('tasks.show', $task) }}" class="btn btn-sm btn-outline-secondary"><i class="bi bi-eye"></i></a>
                            <a href="{{ route('tasks.edit', $task) }}" class="btn btn-sm btn-outline-primary"><i class="bi bi-pencil"></i></a>
                            <form action="{{ route('tasks.destroy', $task) }}" method="POST" class="d-inline">
                                @csrf @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-outline-danger btn-delete-confirm"><i class="bi bi-trash"></i></button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="8" class="text-center text-secondary py-4">Belum ada data task.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
    {{ $tasks->links() }}
</div>
@endsection
