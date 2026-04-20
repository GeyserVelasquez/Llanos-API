<?php

namespace App\Http\Requests\ProductMovementType;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateProductMovementTypeRequest extends FormRequest
{

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        $productMovementType = $this->route('productMovementType');

        return [
            'code' => [
                'required_without:name',
                'string',
                'max:255',
                Rule::unique('product_movement_types', 'code')->ignore($productMovementType)
            ],
            'name' => [
                'required_without:code',
                'string',
                'max:255'
            ],
        ];
    }
}