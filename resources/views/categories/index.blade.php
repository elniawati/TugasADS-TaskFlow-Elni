@extends('layouts.app')
@section('title', 'Kategori')

@section('content')
<div class="card p-3 p-md-4">
    <div class="d-flex flex-wrap justify-content-between align-items-center mb-3 gap-2">
        <h5 class="mb-0"><i class="bi bi-tags me-1"></i> Kategori</h5>
        <a href="{{ route('categories.create') }}" class="btn btn-primary btn-sm">
            <i class="bi bi-plus-lg"></i> Tambah Kategori
        </a>
    </div>

    <form method="GET" class="row g-2 mb-3">
        <div class="col-md-4">
            <input type="text" name="search" class="form-control form-control-sm" placeholder="Cari kategori..." value="{{ request('search') }}">
        </div>
        <div class="col-auto">
            <button class="btn btn-sm btn-outline-secondary"><i class="bi bi-search"></i> Cari</button>
        </div>
    </form>

    <div class="table-responsive">
        <table class="table table-hover align-middle">
            <thead>
                <tr>
                    <th>Nama</th>
                    <th>Warna</th>
                    <th>Deskripsi</th>
                    <th>Jumlah Task</th>
                    <th class="text-end">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($categories as $category)
                    <tr>
                        <td class="fw-medium">{{ $category->name }}</td>
                        <td><span class="badge" style="background-color: {{ $category->color }};">&nbsp;&nbsp;&nbsp;</span></td>
                        <td class="text-secondary small">{{ Str::limit($category->description, 50) }}</td>
                        <td>{{ $category->tasks_count }}</td>
                        <td class="text-end">
                            <a href="{{ route('categories.edit', $category) }}" class="btn btn-sm btn-outline-primary"><i class="bi bi-pencil"></i></a>
                            <form action="{{ route('categories.destroy', $category) }}" method="POST" class="d-inline">
                                @csrf @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-outline-danger btn-delete-confirm"><i class="bi bi-trash"></i></button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="5" class="text-center text-secondary py-4">Belum ada data kategori.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>

    {{ $categories->links() }}
</div>
@endsection
