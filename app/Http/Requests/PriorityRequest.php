<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PriorityRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:50'],
            'level' => ['required', 'integer', 'min:1', 'max:10'],
            'color' => ['required', 'string', 'max:20'],
        ];
    }
}
