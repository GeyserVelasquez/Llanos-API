<?php

namespace App\Http\Requests\EmbrionExtractionType;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreEmbrionExtractionTypeRequest extends FormRequest
{

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'code' => [
                'required',
                'string',
                'max:255',
                Rule::unique('embrion_extraction_types', 'code')
            ],
            'name' => [
                'required',
                'string',
                'max:255'
            ],
        ];
    }
}
