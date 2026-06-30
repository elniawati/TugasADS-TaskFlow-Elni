<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StatusRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:50'],
            'color' => ['required', 'string', 'max:20'],
            'order_position' => ['required', 'integer', 'min:0'],
            'is_final' => ['sometimes', 'boolean'],
        ];
    }
}
