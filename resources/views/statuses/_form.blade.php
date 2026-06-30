<div class="mb-3">
    <label class="form-label">Nama Status</label>
    <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" value="{{ old('name', $status->name ?? '') }}" required>
    @error('name') <div class="invalid-feedback">{{ $message }}</div> @enderror
</div>
<div class="mb-3">
    <label class="form-label">Urutan Tampil</label>
    <input type="number" name="order_position" min="0" class="form-control @error('order_position') is-invalid @enderror" value="{{ old('order_position', $status->order_position ?? 0) }}" required>
    @error('order_position') <div class="invalid-feedback">{{ $message }}</div> @enderror
</div>
<div class="mb-3">
    <label class="form-label">Warna</label>
    <input type="color" name="color" class="form-control form-control-color @error('color') is-invalid @enderror" value="{{ old('color', $status->color ?? '#6c757d') }}">
    @error('color') <div class="invalid-feedback">{{ $message }}</div> @enderror
</div>
<div class="form-check mb-3">
    <input type="checkbox" name="is_final" value="1" class="form-check-input" id="is_final" {{ old('is_final', $status->is_final ?? false) ? 'checked' : '' }}>
    <label class="form-check-label" for="is_final">Status final (Task dianggap selesai/berakhir pada status ini)</label>
</div>
