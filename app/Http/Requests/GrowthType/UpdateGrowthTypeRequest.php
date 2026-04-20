<?php

namespace App\Http\Requests\GrowthType;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateGrowthTypeRequest extends FormRequest
{

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        $growthType = $this->route('growth_type');

        return [
            'code' => [
                'required_without:name',
                'string',
                'max:255',
                Rule::unique('growth_types', 'code')->ignore($growthType)
            ],
            'name' => [
                'required_without:code',
                'string',
                'max:255'
            ],
        ];
    }
}
