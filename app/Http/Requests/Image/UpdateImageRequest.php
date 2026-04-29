<?php

namespace App\Http\Requests\Image;

use Illuminate\Foundation\Http\FormRequest;

class UpdateImageRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name' => ['sometimes', 'required', 'string', 'max:255'],
            'path' => ['sometimes', 'required', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'livestock_id' => ['sometimes', 'required', 'exists:livestock,id'],
        ];
    }
}
