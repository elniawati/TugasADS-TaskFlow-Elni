@extends('layouts.guest')
@section('title', 'Halaman Tidak Ditemukan')
@section('content')
<div class="text-center">
    <i class="bi bi-search text-secondary" style="font-size:3rem;"></i>
    <h4 class="mt-3">404 - Halaman Tidak Ditemukan</h4>
    <p class="text-secondary">Halaman yang Anda cari tidak tersedia.</p>
    <a href="{{ route('dashboard') }}" class="btn btn-primary btn-sm">Kembali ke Dashboard</a>
</div>
@endsection
