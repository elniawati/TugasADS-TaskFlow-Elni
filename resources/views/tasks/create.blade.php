@extends('layouts.app')
@section('title', 'Tambah Task')
@section('content')
<div class="card p-3 p-md-4">
    <h5 class="mb-3"><i class="bi bi-plus-lg"></i> Tambah Task</h5>
    <form method="POST" action="{{ route('tasks.store') }}" enctype="multipart/form-data">
        @csrf
        @include('tasks._form')
        <button type="submit" class="btn btn-primary"><i class="bi bi-save"></i> Simpan</button>
        <a href="{{ route('tasks.index') }}" class="btn btn-outline-secondary">Batal</a>
    </form>
</div>
@endsection
