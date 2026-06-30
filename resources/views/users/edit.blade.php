@extends('layouts.app')
@section('title', 'Edit User')
@section('content')
<div class="card p-3 p-md-4 col-lg-6">
    <h5 class="mb-3"><i class="bi bi-pencil"></i> Edit User</h5>
    <form method="POST" action="{{ route('users.update', $user) }}">
        @csrf @method('PUT')
        @include('users._form')
        <button type="submit" class="btn btn-primary"><i class="bi bi-save"></i> Perbarui</button>
        <a href="{{ route('users.index') }}" class="btn btn-outline-secondary">Batal</a>
    </form>
</div>
@endsection
