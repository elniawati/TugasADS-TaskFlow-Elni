@extends('layouts.app')
@section('title', 'Tambah User')
@section('content')
<div class="card p-3 p-md-4 col-lg-6">
    <h5 class="mb-3"><i class="bi bi-plus-lg"></i> Tambah User</h5>
    <form method="POST" action="{{ route('users.store') }}">
        @csrf
        @include('users._form')
        <button type="submit" class="btn btn-primary"><i class="bi bi-save"></i> Simpan</button>
        <a href="{{ route('users.index') }}" class="btn btn-outline-secondary">Batal</a>
    </form>
</div>
@endsection
