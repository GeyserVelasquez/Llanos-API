<?php

namespace App\Http\Requests\Breed;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateBreedRequest extends FormRequest
{

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        $breed = $this->route('breed');

        return [
            'code' => [
                'required_without:name',
                'string',
                'max:255',
                Rule::unique('breeds', 'code')->ignore($breed)
            ],
            'name' => [
                'required_without:code',
                'string',
                'max:255'
            ],
        ];
    }
}
