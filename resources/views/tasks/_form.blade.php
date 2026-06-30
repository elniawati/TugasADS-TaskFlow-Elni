<div class="row">
    <div class="col-md-8">
        <div class="mb-3">
            <label class="form-label">Judul Task</label>
            <input type="text" name="title" class="form-control @error('title') is-invalid @enderror" value="{{ old('title', $task->title ?? '') }}" required>
            @error('title') <div class="invalid-feedback">{{ $message }}</div> @enderror
        </div>

        <div class="mb-3">
            <label class="form-label">Deskripsi</label>
            <textarea name="description" rows="4" class="form-control @error('description') is-invalid @enderror">{{ old('description', $task->description ?? '') }}</textarea>
            @error('description') <div class="invalid-feedback">{{ $message }}</div> @enderror
        </div>

        <div class="mb-3">
            <label class="form-label">Catatan</label>
            <textarea name="notes" rows="3" class="form-control @error('notes') is-invalid @enderror">{{ old('notes', $task->notes ?? '') }}</textarea>
            @error('notes') <div class="invalid-feedback">{{ $message }}</div> @enderror
        </div>

        <div class="mb-3">
            <label class="form-label">Lampiran (PDF, gambar, dokumen, maks. 5MB/file, maks 5 file)</label>
            <input type="file" name="attachments[]" multiple class="form-control @error('attachments.*') is-invalid @enderror">
            @error('attachments.*') <div class="invalid-feedback d-block">{{ $message }}</div> @enderror

            @if(isset($task) && $task->files->count())
                <ul class="list-group mt-2">
                    @foreach($task->files as $file)
                        <li class="list-group-item d-flex justify-content-between align-items-center py-2">
                            <span><i class="bi bi-paperclip"></i> {{ $file->original_name }} <span class="text-secondary small">({{ $file->humanSize() }})</span></span>
                            <span>
                                <a href="{{ route('task-files.preview', $file) }}" target="_blank" class="btn btn-sm btn-outline-secondary"><i class="bi bi-eye"></i></a>
                                <a href="{{ route('task-files.download', $file) }}" class="btn btn-sm btn-outline-primary"><i class="bi bi-download"></i></a>
                                <form action="{{ route('task-files.destroy', $file) }}" method="POST" class="d-inline">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-outline-danger btn-delete-confirm"><i class="bi bi-trash"></i></button>
                                </form>
                            </span>
                        </li>
                    @endforeach
                </ul>
            @endif
        </div>
    </div>

    <div class="col-md-4">
        <div class="mb-3">
            <label class="form-label">Kategori</label>
            <select name="category_id" class="form-select @error('category_id') is-invalid @enderror" required>
                <option value="">-- Pilih Kategori --</option>
                @foreach($categories as $category)
                    <option value="{{ $category->id }}" {{ old('category_id', $task->category_id ?? '') == $category->id ? 'selected' : '' }}>{{ $category->name }}</option>
                @endforeach
            </select>
            @error('category_id') <div class="invalid-feedback">{{ $message }}</div> @enderror
        </div>

        <div class="mb-3">
            <label class="form-label">Prioritas</label>
            <select name="priority_id" class="form-select @error('priority_id') is-invalid @enderror" required>
                <option value="">-- Pilih Prioritas --</option>
                @foreach($priorities as $priority)
                    <option value="{{ $priority->id }}" {{ old('priority_id', $task->priority_id ?? '') == $priority->id ? 'selected' : '' }}>{{ $priority->name }}</option>
                @endforeach
            </select>
            @error('priority_id') <div class="invalid-feedback">{{ $message }}</div> @enderror
        </div>

        <div class="mb-3">
            <label class="form-label">Status</label>
            <select name="status_id" class="form-select @error('status_id') is-invalid @enderror" required>
                <option value="">-- Pilih Status --</option>
                @foreach($statuses as $status)
                    <option value="{{ $status->id }}" {{ old('status_id', $task->status_id ?? '') == $status->id ? 'selected' : '' }}>{{ $status->name }}</option>
                @endforeach
            </select>
            @error('status_id') <div class="invalid-feedback">{{ $message }}</div> @enderror
        </div>

        <div class="mb-3">
            <label class="form-label">Deadline</label>
            <input type="date" name="deadline" class="form-control @error('deadline') is-invalid @enderror" value="{{ old('deadline', isset($task) ? $task->deadline->format('Y-m-d') : '') }}" required>
            @error('deadline') <div class="invalid-feedback">{{ $message }}</div> @enderror
        </div>

        @if(auth()->user()->isAdmin())
            <div class="mb-3">
                <label class="form-label">Ditugaskan kepada</label>
                <select name="user_id" class="form-select @error('user_id') is-invalid @enderror">
                    @foreach($users as $u)
                        <option value="{{ $u->id }}" {{ old('user_id', $task->user_id ?? auth()->id()) == $u->id ? 'selected' : '' }}>{{ $u->name }}</option>
                    @endforeach
                </select>
                @error('user_id') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>
        @endif
    </div>
</div>
