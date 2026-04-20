<?php

namespace App\Http\Requests\SupplyType;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateSupplyTypeRequest extends FormRequest
{

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        $supplyType = $this->route('supply_type');

        return [
            'code' => [
                'required_without:name',
                'string',
                'max:255',
                Rule::unique('supply_types', 'code')->ignore($supplyType)
            ],
            'name' => [
                'required_without:code',
                'string',
                'max:255'
            ],
        ];
    }
}
