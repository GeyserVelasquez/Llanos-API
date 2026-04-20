<?php

namespace App\Http\Requests\EntryCause;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateEntryCauseRequest extends FormRequest
{

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        $entryCause = $this->route('entryCause');

        return [
            'code' => [
                'required_without:name',
                'string',
                'max:255',
                Rule::unique('entry_causes', 'code')->ignore($entryCause)
            ],
            'name' => [
                'required_without:code',
                'string',
                'max:255'
            ],
        ];
    }
}