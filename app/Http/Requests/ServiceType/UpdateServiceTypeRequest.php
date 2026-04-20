<?php

namespace App\Http\Requests\ServiceType;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateServiceTypeRequest extends FormRequest
{

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        $serviceType = $this->route('service_type');

        return [
            'code' => [
                'required_without:name',
                'string',
                'max:255',
                Rule::unique('service_types', 'code')->ignore($serviceType)
            ],
            'name' => [
                'required_without:code',
                'string',
                'max:255'
            ],
        ];
    }
}
