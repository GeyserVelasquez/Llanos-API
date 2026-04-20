<?php

namespace App\Http\Requests\NewbornType;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateNewbornTypeRequest extends FormRequest
{

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        $newbornType = $this->route('newbornType');

        return [
            'code' => [
                'required_without:name',
                'string',
                'max:255',
                Rule::unique('newborn_types', 'code')->ignore($newbornType)
            ],
            'name' => [
                'required_without:code',
                'string',
                'max:255'
            ],
        ];
    }
}