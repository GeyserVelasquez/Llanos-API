<?php

namespace App\Http\Requests\BatchMovement;

use Illuminate\Foundation\Http\FormRequest;

class UpdateBatchMovementRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'batch_id' => ['sometimes', 'required', 'exists:batches,id'],
            'livestock_id' => ['sometimes', 'required', 'exists:livestock,id'],
            'made_at' => ['sometimes', 'required', 'date'],
            'attributes' => ['nullable', 'array']
        ];
    }
}
