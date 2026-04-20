<?php

namespace App\Http\Requests\AbortType;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateAbortTypeRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        $abortType = $this->route('abort_type');

        return [
            'code' => [
                'required_without:name',
                'string',
                'max:255',
                Rule::unique('abort_types', 'code')->ignore($abortType)
            ],
            'name' => [
                'required_without:code',
                'string',
                'max:255'
            ],
        ];
    }
}
