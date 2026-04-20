<?php

namespace App\Http\Requests\EmbrionExtractionType;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateEmbrionExtractionTypeRequest extends FormRequest
{

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        $embrionExtractionType = $this->route('embrion_extraction_type');

        return [
            'code' => [
                'required_without:name',
                'string',
                'max:255',
                Rule::unique('embrion_extraction_types', 'code')->ignore($embrionExtractionType)
            ],
            'name' => [
                'required_without:code',
                'string',
                'max:255'
            ],
        ];
    }
}
