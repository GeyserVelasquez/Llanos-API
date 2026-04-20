<?php

namespace App\Http\Requests\OutcomeType;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateOutcomeTypeRequest extends FormRequest
{

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        $outcomeType = $this->route('outcomeType');

        return [
            'code' => [
                'required_without:name',
                'string',
                'max:255',
                Rule::unique('outcome_types', 'code')->ignore($outcomeType)
            ],
            'name' => [
                'required_without:code',
                'string',
                'max:255'
            ],
        ];
    }
}