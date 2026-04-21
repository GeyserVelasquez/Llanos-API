<?php

namespace App\Models;

use App\Enums\MovementType;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Relations\MorphTo;

#[Fillable(['item_id', 'item_type', 'type', 'quantity', 'event_id', 'event_type', 'date'])]
class MovementKardex extends Model
{
    use SoftDeletes;

    protected $table = 'movement_kardex';

    protected function casts(): array
    {
        return [
            'date' => 'datetime',
            'type' => MovementType::class,
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
}
