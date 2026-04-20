<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

#[Fillable(['item_id', 'item_type', 'product_movement_type_id', 'quantity', 'event_id', 'event_type', 'date'])]
class MovementKardex extends Model
{
    use SoftDeletes;

    protected $table = 'movement_kardex';

    protected function casts(): array
    {
        return [
            'date' => 'datetime',
        ];
    }

    public function item(): MorphTo
    {
        return $this->morphTo();
    }

    public function event(): MorphTo
    {
        return $this->morphTo();
    }

    public function productMovementType(): BelongsTo
    {
        return $this->belongsTo(ProductMovementType::class);
    }
}
