@extends('layouts.guest')

@section('title', 'Login')

@section('content')
    <h4 class="fw-semibold mb-1">Masuk ke akun Anda</h4>
    <p class="text-secondary small mb-4">Silakan login untuk mengakses TaskFlow.</p>

    <form method="POST" action="{{ route('login') }}">
        @csrf

        <div class="mb-3">
            <label class="form-label">Email</label>
            <input type="email" name="email" class="form-control @error('email') is-invalid @enderror" value="{{ old('email') }}" required autofocus>
            @error('email')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-3">
            <label class="form-label">Password</label>
            <input type="password" name="password" class="form-control @error('password') is-invalid @enderror" required>
            @error('password')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="form-check mb-3">
            <input class="form-check-input" type="checkbox" name="remember" id="remember">
            <label class="form-check-label" for="remember">Ingat saya</label>
        </div>

        <button type="submit" class="btn btn-primary w-100">
            <i class="bi bi-box-arrow-in-right me-1"></i> Login
        </button>
    </form>

    <hr class="my-4">
    <p class="text-center text-secondary small mb-0">
        Akun demo: <code>admin@taskflow.test</code> / <code>password</code>
    </p>
@endsection
