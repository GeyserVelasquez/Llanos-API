<?php

namespace App\Http\Requests\ExtractionType;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateExtractionTypeRequest extends FormRequest
{

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        $extractionType = $this->route('extractionType');

        return [
            'code' => [
                'required_without:name',
                'string',
                'max:255',
                Rule::unique('extraction_types', 'code')->ignore($extractionType)
            ],
            'name' => [
                'required_without:code',
                'string',
                'max:255'
            ],
        ];
    }
}