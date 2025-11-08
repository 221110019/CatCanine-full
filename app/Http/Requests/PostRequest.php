<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PostRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'caption' => 'required|string|max:200',
            'picture' => 'nullable|file|mimes:jpg,jpeg,webp,png',
        ];
    }
}
