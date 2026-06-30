@extends('layouts.app')
@section('title', 'Edit Task')
@section('content')
<div class="card p-3 p-md-4">
    <h5 class="mb-3"><i class="bi bi-pencil"></i> Edit Task</h5>
    <form method="POST" action="{{ route('tasks.update', $task) }}" enctype="multipart/form-data">
        @csrf @method('PUT')
        @include('tasks._form')
        <button type="submit" class="btn btn-primary"><i class="bi bi-save"></i> Perbarui</button>
        <a href="{{ route('tasks.index') }}" class="btn btn-outline-secondary">Batal</a>
    </form>
</div>
@endsection
