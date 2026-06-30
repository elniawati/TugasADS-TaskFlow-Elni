@extends('layouts.app')
@section('title', 'Status')

@section('content')
<div class="card p-3 p-md-4">
    <div class="d-flex flex-wrap justify-content-between align-items-center mb-3 gap-2">
        <h5 class="mb-0"><i class="bi bi-bookmark-check me-1"></i> Status</h5>
        <a href="{{ route('statuses.create') }}" class="btn btn-primary btn-sm"><i class="bi bi-plus-lg"></i> Tambah Status</a>
    </div>

    <div class="table-responsive">
        <table class="table table-hover align-middle">
            <thead>
                <tr><th>Nama</th><th>Urutan</th><th>Warna</th><th>Final?</th><th>Jumlah Task</th><th class="text-end">Aksi</th></tr>
            </thead>
            <tbody>
                @forelse($statuses as $status)
                    <tr>
                        <td class="fw-medium">{{ $status->name }}</td>
                        <td>{{ $status->order_position }}</td>
                        <td><span class="badge" style="background-color: {{ $status->color }};">&nbsp;&nbsp;&nbsp;</span></td>
                        <td>
                            @if($status->is_final)
                                <span class="badge bg-success-subtle text-success-emphasis">Ya</span>
                            @else
                                <span class="badge bg-secondary-subtle text-secondary-emphasis">Tidak</span>
                            @endif
                        </td>
                        <td>{{ $status->tasks_count }}</td>
                        <td class="text-end">
                            <a href="{{ route('statuses.edit', $status) }}" class="btn btn-sm btn-outline-primary"><i class="bi bi-pencil"></i></a>
                            <form action="{{ route('statuses.destroy', $status) }}" method="POST" class="d-inline">
                                @csrf @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-outline-danger btn-delete-confirm"><i class="bi bi-trash"></i></button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="6" class="text-center text-secondary py-4">Belum ada data status.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
    {{ $statuses->links() }}
</div>
@endsection
