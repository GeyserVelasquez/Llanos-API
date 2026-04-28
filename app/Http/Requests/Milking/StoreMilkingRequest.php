<?php

namespace App\Http\Requests\Milking;

use Illuminate\Foundation\Http\FormRequest;

class StoreMilkingRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'livestock_id' => ['required', 'exists:livestock,id'],
            'made_at' => ['required', 'date'],
            'milking_type_id' => ['required', 'exists:milking_types,id'],
            'first_weight' => ['required', 'numeric', 'min:0'],
            'second_weight' => ['required', 'numeric', 'min:0'],
            'third_weight' => ['required', 'numeric', 'min:0'],
        ];
    }
}
