<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreTaskRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'title' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'notes' => ['nullable', 'string'],
            'category_id' => ['required', 'exists:categories,id'],
            'priority_id' => ['required', 'exists:priorities,id'],
            'status_id' => ['required', 'exists:statuses,id'],
            'deadline' => ['required', 'date'],
            'user_id' => ['sometimes', 'exists:users,id'],
            'attachments' => ['nullable', 'array', 'max:5'],
            'attachments.*' => ['file', 'max:5120', 'mimes:pdf,jpg,jpeg,png,doc,docx,xls,xlsx'],
        ];
    }

    public function messages(): array
    {
        return [
            'title.required' => 'Judul task wajib diisi.',
            'category_id.required' => 'Kategori wajib dipilih.',
            'priority_id.required' => 'Prioritas wajib dipilih.',
            'status_id.required' => 'Status wajib dipilih.',
            'deadline.required' => 'Deadline wajib diisi.',
            'attachments.*.max' => 'Ukuran file maksimal 5 MB.',
            'attachments.*.mimes' => 'Format file tidak didukung.',
            'attachments.max' => 'Maksimal 5 file dapat diunggah sekaligus.',
        ];
    }
}
