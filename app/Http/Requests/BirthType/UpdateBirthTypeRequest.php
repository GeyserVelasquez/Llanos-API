<?php

namespace App\Http\Requests\BirthType;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateBirthTypeRequest extends FormRequest
{

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        $birthType = $this->route('birthType');

        return [
            'code' => [
                'required_without:name',
                'string',
                'max:255',
                Rule::unique('birth_types', 'code')->ignore($birthType)
            ],
            'name' => [
                'required_without:code',
                'string',
                'max:255'
            ],
        ];
    }
}