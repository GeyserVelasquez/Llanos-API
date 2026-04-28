<?php

namespace App\Traits;

use Illuminate\Database\Eloquent\Builder;

trait HasInclude
{
    protected function parseIncludes(?string $includes): array
    {
        if (empty($includes) || !property_exists($this, 'allowIncludes')) {
            return [];
        }

        $requested = explode(',', $includes);

        return array_intersect($requested, $this->allowIncludes);
    }

    /**
     * Scope para cargar relaciones dinámicas.
     * Ahora RECIBE el string, no va a buscarlo al Request.
     */
    public function scopeIncluded(Builder $query, ?string $includes): Builder
    {
        $validIncludes = $this->parseIncludes($includes);

        return empty($validIncludes) ? $query : $query->with($validIncludes);
    }

    /**
     * Cargar relaciones dinámicas en una instancia existente.
     */
    public function loadIncludes(?string $includes): self
    {
        $validIncludes = $this->parseIncludes($includes);

        if (!empty($validIncludes)) {
            $this->load($validIncludes);
        }

        return $this;
    }
}
