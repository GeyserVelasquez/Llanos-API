<?php

namespace App\Models;

use Illuminate\Database\Eloquent\SoftDeletes;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

#[Fillable(['product_id', 'product_movement_type_id', 'made_at', 'attributes'])]
class ProductMovement extends Model
{
    use SoftDeletes;



    protected function casts(): array
    {
        return [
            'made_at' => 'datetime',
            'attributes' => 'array',
        ];
    }

    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }

    public function productMovementType(): BelongsTo
    {
        return $this->belongsTo(ProductMovementType::class);
    }
}
