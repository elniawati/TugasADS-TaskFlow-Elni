@extends('layouts.app')
@section('title', 'Profile')

@section('content')
<div class="row g-3">
    <div class="col-lg-6">
        <div class="card p-3 p-md-4">
            <h6 class="mb-3"><i class="bi bi-person-circle"></i> Informasi Profile</h6>
            <form method="POST" action="{{ route('profile.update') }}" enctype="multipart/form-data">
                @csrf @method('PATCH')

                @if($user->avatar)
                    <img src="{{ asset('storage/'.$user->avatar) }}" class="rounded-circle mb-3" width="80" height="80" style="object-fit:cover;">
                @endif

                <div class="mb-3">
                    <label class="form-label">Foto Profile</label>
                    <input type="file" name="avatar" class="form-control @error('avatar') is-invalid @enderror">
                    @error('avatar') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>

                <div class="mb-3">
                    <label class="form-label">Nama Lengkap</label>
                    <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" value="{{ old('name', $user->name) }}" required>
                    @error('name') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>

                <div class="mb-3">
                    <label class="form-label">Email</label>
                    <input type="email" name="email" class="form-control @error('email') is-invalid @enderror" value="{{ old('email', $user->email) }}" required>
                    @error('email') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>

                <div class="mb-3">
                    <label class="form-label">Telepon</label>
                    <input type="text" name="phone" class="form-control @error('phone') is-invalid @enderror" value="{{ old('phone', $user->phone) }}">
                    @error('phone') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>

                <button type="submit" class="btn btn-primary"><i class="bi bi-save"></i> Simpan Perubahan</button>
            </form>
        </div>
    </div>

    <div class="col-lg-6">
        <div class="card p-3 p-md-4">
            <h6 class="mb-3"><i class="bi bi-shield-lock"></i> Ganti Password</h6>
            <form method="POST" action="{{ route('profile.password') }}">
                @csrf @method('PUT')

                <div class="mb-3">
                    <label class="form-label">Password Saat Ini</label>
                    <input type="password" name="current_password" class="form-control @error('current_password') is-invalid @enderror" required>
                    @error('current_password') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>

                <div class="mb-3">
                    <label class="form-label">Password Baru</label>
                    <input type="password" name="password" class="form-control @error('password') is-invalid @enderror" required>
                    @error('password') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>

                <div class="mb-3">
                    <label class="form-label">Konfirmasi Password Baru</label>
                    <input type="password" name="password_confirmation" class="form-control" required>
                </div>

                <button type="submit" class="btn btn-primary"><i class="bi bi-key"></i> Ubah Password</button>
            </form>
        </div>
    </div>
</div>
@endsection
