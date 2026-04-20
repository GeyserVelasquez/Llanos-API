<?php

namespace App\Http\Requests\ProductType;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateProductTypeRequest extends FormRequest
{

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        $productType = $this->route('product_type');

        return [
            'code' => [
                'required_without:name',
                'string',
                'max:255',
                Rule::unique('product_types', 'code')->ignore($productType)
            ],
            'name' => [
                'required_without:code',
                'string',
                'max:255'
            ],
        ];
    }
}
