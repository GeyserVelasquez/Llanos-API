<?php

namespace App\Http\Requests\AnimalCategory;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateAnimalCategoryRequest extends FormRequest
{

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        $animalCategory = $this->route('animal_category');

        return [
            'code' => [
                'required_without:name',
                'string',
                'max:255',
                Rule::unique('animal_categories', 'code')->ignore($animalCategory)
            ],
            'name' => [
                'required_without:code',
                'string',
                'max:255'
            ],
        ];
    }
}
