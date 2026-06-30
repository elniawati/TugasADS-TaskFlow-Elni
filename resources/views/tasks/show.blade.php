@extends('layouts.app')
@section('title', 'Detail Task')

@section('content')
<div class="row g-3">
    <div class="col-lg-8">
        <div class="card p-3 p-md-4">
            <div class="d-flex justify-content-between align-items-start mb-3">
                <div>
                    <h5 class="mb-1">{{ $task->title }}</h5>
                    <span class="badge badge-soft" style="background-color: {{ $task->category->color }}22; color: {{ $task->category->color }};">{{ $task->category->name }}</span>
                    <span class="badge badge-soft" style="background-color: {{ $task->priority->color }}22; color: {{ $task->priority->color }};">{{ $task->priority->name }}</span>
                    <span class="badge badge-soft" style="background-color: {{ $task->status->color }}22; color: {{ $task->status->color }};">{{ $task->status->name }}</span>
                    @if($task->isOverdue())
                        <span class="badge bg-danger-subtle text-danger-emphasis">Overdue</span>
                    @endif
                </div>
                <div>
                    <a href="{{ route('tasks.edit', $task) }}" class="btn btn-sm btn-outline-primary"><i class="bi bi-pencil"></i> Edit</a>
                </div>
            </div>

            <p class="text-secondary mb-1 small">Pemilik: <strong>{{ $task->user->name }}</strong> &middot; Deadline: <strong>{{ $task->deadline->format('d M Y') }}</strong></p>

            <hr>
            <h6>Deskripsi</h6>
            <p>{{ $task->description ?: '-' }}</p>

            @if($task->notes)
                <h6>Catatan</h6>
                <p>{{ $task->notes }}</p>
            @endif

            <h6 class="mt-3">Lampiran</h6>
            @forelse($task->files as $file)
                <div class="d-flex justify-content-between align-items-center border-bottom py-2">
                    <span><i class="bi bi-paperclip"></i> {{ $file->original_name }} <span class="text-secondary small">({{ $file->humanSize() }}) &middot; oleh {{ $file->uploader->name }}</span></span>
                    <span>
                        <a href="{{ route('task-files.preview', $file) }}" target="_blank" class="btn btn-sm btn-outline-secondary"><i class="bi bi-eye"></i> Preview</a>
                        <a href="{{ route('task-files.download', $file) }}" class="btn btn-sm btn-outline-primary"><i class="bi bi-download"></i> Download</a>
                    </span>
                </div>
            @empty
                <p class="text-secondary small">Belum ada lampiran.</p>
            @endforelse
        </div>
    </div>

    <div class="col-lg-4">
        <div class="card p-3 p-md-4">
            <h6 class="mb-3"><i class="bi bi-clock-history"></i> Riwayat Aktivitas</h6>
            @forelse($task->activityLogs as $log)
                <div class="d-flex gap-2 border-bottom py-2">
                    <i class="bi bi-dot fs-4 text-primary"></i>
                    <div>
                        <div class="small"><strong>{{ $log->user->name ?? 'Sistem' }}</strong> {{ $log->description }}</div>
                        <div class="text-secondary" style="font-size: .75rem;">{{ $log->created_at->diffForHumans() }}</div>
                    </div>
                </div>
            @empty
                <p class="text-secondary small mb-0">Belum ada aktivitas.</p>
            @endforelse
        </div>
    </div>
</div>
@endsection
