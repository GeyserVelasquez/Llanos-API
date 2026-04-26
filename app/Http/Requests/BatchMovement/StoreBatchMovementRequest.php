<?php

namespace App\Http\Requests\BatchMovement;

use Illuminate\Foundation\Http\FormRequest;

class StoreBatchMovementRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'batch_id' => ['required', 'exists:batches,id'],
            'livestock_id' => ['required', 'exists:livestock,id'],
            'made_at' => ['required', 'date'],
            'attributes' => ['nullable', 'array']
        ];
    }
}
