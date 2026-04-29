<?php

namespace App\Rules\Livestock;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;
use Carbon\Carbon;

class BirthDatePrecedesEntry implements ValidationRule
{
    public function __construct(protected $entryDate) {}

    /**
     * Valida que la fecha de nacimiento sea menor o igual que la de ingreso.
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        if (!$value || !$this->entryDate) return;

        $birthDate = Carbon::parse($value);
        $entryDate = Carbon::parse($this->entryDate);

        if ($birthDate->gt($entryDate)) {
            $fail("La fecha de nacimiento no puede ser posterior a la fecha de ingreso.");
        }
    }
}
