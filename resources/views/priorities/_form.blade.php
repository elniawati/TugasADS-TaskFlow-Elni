<div class="mb-3">
    <label class="form-label">Nama Prioritas</label>
    <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" value="{{ old('name', $priority->name ?? '') }}" required>
    @error('name') <div class="invalid-feedback">{{ $message }}</div> @enderror
</div>
<div class="mb-3">
    <label class="form-label">Level (1-10, makin tinggi makin prioritas)</label>
    <input type="number" name="level" min="1" max="10" class="form-control @error('level') is-invalid @enderror" value="{{ old('level', $priority->level ?? 1) }}" required>
    @error('level') <div class="invalid-feedback">{{ $message }}</div> @enderror
</div>
<div class="mb-3">
    <label class="form-label">Warna</label>
    <input type="color" name="color" class="form-control form-control-color @error('color') is-invalid @enderror" value="{{ old('color', $priority->color ?? '#6c757d') }}">
    @error('color') <div class="invalid-feedback">{{ $message }}</div> @enderror
</div>
