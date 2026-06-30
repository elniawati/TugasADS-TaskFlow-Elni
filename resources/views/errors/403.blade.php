@extends('layouts.guest')
@section('title', 'Akses Ditolak')
@section('content')
<div class="text-center">
    <i class="bi bi-shield-exclamation text-danger" style="font-size:3rem;"></i>
    <h4 class="mt-3">403 - Akses Ditolak</h4>
    <p class="text-secondary">{{ $exception->getMessage() ?: 'Anda tidak memiliki izin untuk mengakses halaman ini.' }}</p>
    <a href="{{ url()->previous() }}" class="btn btn-primary btn-sm">Kembali</a>
</div>
@endsection
