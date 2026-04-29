<?php

namespace App\Http\Requests\Milking;

use Illuminate\Foundation\Http\FormRequest;

class UpdateMilkingRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'livestock_id' => ['sometimes', 'required', 'exists:livestock,id'],
            'made_at' => ['sometimes', 'required', 'date'],
            'milking_type_id' => ['sometimes', 'required', 'exists:milking_types,id'],
            'first_weight' => ['sometimes', 'required', 'numeric', 'min:0'],
            'second_weight' => ['sometimes', 'required', 'numeric', 'min:0'],
            'third_weight' => ['sometimes', 'required', 'numeric', 'min:0'],
        ];
    }
}
