@extends('layouts.app')
@section('title', 'Prioritas')

@section('content')
<div class="card p-3 p-md-4">
    <div class="d-flex flex-wrap justify-content-between align-items-center mb-3 gap-2">
        <h5 class="mb-0"><i class="bi bi-flag me-1"></i> Prioritas</h5>
        <a href="{{ route('priorities.create') }}" class="btn btn-primary btn-sm"><i class="bi bi-plus-lg"></i> Tambah Prioritas</a>
    </div>

    <div class="table-responsive">
        <table class="table table-hover align-middle">
            <thead>
                <tr><th>Nama</th><th>Level</th><th>Warna</th><th>Jumlah Task</th><th class="text-end">Aksi</th></tr>
            </thead>
            <tbody>
                @forelse($priorities as $priority)
                    <tr>
                        <td class="fw-medium">{{ $priority->name }}</td>
                        <td>{{ $priority->level }}</td>
                        <td><span class="badge" style="background-color: {{ $priority->color }};">&nbsp;&nbsp;&nbsp;</span></td>
                        <td>{{ $priority->tasks_count }}</td>
                        <td class="text-end">
                            <a href="{{ route('priorities.edit', $priority) }}" class="btn btn-sm btn-outline-primary"><i class="bi bi-pencil"></i></a>
                            <form action="{{ route('priorities.destroy', $priority) }}" method="POST" class="d-inline">
                                @csrf @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-outline-danger btn-delete-confirm"><i class="bi bi-trash"></i></button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="5" class="text-center text-secondary py-4">Belum ada data prioritas.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
    {{ $priorities->links() }}
</div>
@endsection
