<?php

namespace App\Models;

use Illuminate\Database\Eloquent\SoftDeletes;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

#[Fillable(['code', 'name', 'attributes', 'supply_type_id'])]
class Supply extends Model
{
    use SoftDeletes, HasFactory;

    protected function casts(): array
    {
        return [
            'attributes' => 'array',
        ];
    }

    public function supplyType(): BelongsTo
    {
        return $this->belongsTo(SupplyType::class);
    }

    public function clinicalTreatmentSupplies(): HasMany
    {
        return $this->hasMany(ClinicalTreatmentSupply::class);
    }
}
