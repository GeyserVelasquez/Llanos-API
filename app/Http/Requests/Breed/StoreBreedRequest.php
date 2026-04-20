<?php

namespace App\Http\Requests\Breed;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreBreedRequest extends FormRequest
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
                'sometimes',
                'required',
                'string',
                'max:255',
                Rule::unique('breeds', 'code')
            ],
            'name' => [
                'sometimes',
                'required',
                'string',
                'max:255'
            ],
        ];
    }
}
