<?php

namespace App\Models;

use Illuminate\Database\Eloquent\SoftDeletes;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphTo;

#[Fillable(['code', 'name', 'unit_price', 'origin_type', 'origin_id', 'product_type_id'])]
class Product extends Model
{
    use SoftDeletes;



    public function productType(): BelongsTo
    {
        return $this->belongsTo(ProductType::class);
    }

    public function origin(): MorphTo
    {
        return $this->morphTo();
    }

    public function productMovements(): HasMany
    {
        return $this->hasMany(ProductMovement::class);
    }
}
