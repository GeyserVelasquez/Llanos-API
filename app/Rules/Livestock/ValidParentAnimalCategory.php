<?php

namespace App\Rules\Livestock;

use App\Models\Livestock;
use App\Enums\AnimalCategory;
use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class ValidParentAnimalCategory implements ValidationRule
{
    public function __construct(protected string $parentType) {}

    /**
     * Valida que la categoría del padre o madre sea la correcta.
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        $parent = Livestock::find($value);
        if (!$parent) return;

        if ($this->parentType === 'father') {
            if (!in_array($parent->animal_category, [AnimalCategory::BULL, AnimalCategory::STEER])) {
                $fail("El padre debe ser de categoría 'bull' o 'steer'.");
            }
        } elseif ($this->parentType === 'mother') {
            if (!in_array($parent->animal_category, [AnimalCategory::COW, AnimalCategory::HEIFER])) {
                $fail("La madre debe ser de categoría 'cow' o 'heifer'.");
            }
        }
    }
}
