<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

#[Fillable(['code', 'name', 'supply_id'])]
class SupplyCharacteristic extends Model
{


    public function supply(): BelongsTo
    {
        return $this->belongsTo(Supply::class);
    }
}
