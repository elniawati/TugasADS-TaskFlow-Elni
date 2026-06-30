@extends('layouts.app')
@section('title', 'Edit Prioritas')
@section('content')
<div class="card p-3 p-md-4 col-lg-6">
    <h5 class="mb-3"><i class="bi bi-pencil"></i> Edit Prioritas</h5>
    <form method="POST" action="{{ route('priorities.update', $priority) }}">
        @csrf @method('PUT')
        @include('priorities._form')
        <button type="submit" class="btn btn-primary"><i class="bi bi-save"></i> Perbarui</button>
        <a href="{{ route('priorities.index') }}" class="btn btn-outline-secondary">Batal</a>
    </form>
</div>
@endsection
