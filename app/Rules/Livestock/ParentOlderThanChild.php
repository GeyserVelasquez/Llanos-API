<?php

namespace App\Rules\Livestock;

use App\Models\Livestock;
use Closure;
use Illuminate\Contracts\Validation\ValidationRule;
use Carbon\Carbon;

class ParentOlderThanChild implements ValidationRule
{
    public function __construct(protected $childBirthDate) {}

    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        $parent = Livestock::find($value);
        if (!$parent || !$parent->birth_date || !$this->childBirthDate) return;

        $childDate = Carbon::parse($this->childBirthDate);

        // father, mother[s] deben ser mayores (birth_date anterior) que el livestock
        if ($parent->birth_date->greaterThanOrEqualTo($childDate)) {
            $fail("El progenitor debe haber nacido antes que la cría.");
        }
    }
}
