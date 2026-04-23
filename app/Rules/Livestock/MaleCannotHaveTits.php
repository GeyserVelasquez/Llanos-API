<?php

namespace App\Rules\Livestock;

use App\Enums\AnimalCategory;
use Closure;
use Illuminate\Contracts\Validation\DataAwareRule;
use Illuminate\Contracts\Validation\ValidationRule;

class MaleCannotHaveTits implements ValidationRule, DataAwareRule
{
    protected array $data = [];

    public function setData(array $data): static
    {
        $this->data = $data;
        return $this;
    }

    /**
     * Valida que si la categoría es macho, el valor de tits sea 0.
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        $categoryValue = $this->data['animal_category'] ?? null;
        if (!$categoryValue) return;

        $category = AnimalCategory::tryFrom($categoryValue);
        
        if ($category?->isMale() && (int)$value !== 0) {
            $fail("Si la categoría es macho ({$category->value}), los pezones (tits) deben ser 0.");
        }
    }
}
