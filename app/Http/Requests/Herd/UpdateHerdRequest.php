<?php

namespace App\Http\Requests\Herd;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateHerdRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        $herd = $this->route('herd');

        return [
            'code' => [
                'required_without:name',
                'string',
                'max:255',
                Rule::unique('herds', 'code')->ignore($herd)
            ],
            'name' => [
                'required_without:code',
                'string',
                'max:255'
            ],
        ];
    }
}
