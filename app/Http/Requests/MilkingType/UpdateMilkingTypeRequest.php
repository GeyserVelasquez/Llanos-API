<?php

namespace App\Http\Requests\MilkingType;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateMilkingTypeRequest extends FormRequest
{

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        $milkingType = $this->route('milkingType');

        return [
            'code' => [
                'required_without:name',
                'string',
                'max:255',
                Rule::unique('milking_types', 'code')->ignore($milkingType)
            ],
            'name' => [
                'required_without:code',
                'string',
                'max:255'
            ],
        ];
    }
}