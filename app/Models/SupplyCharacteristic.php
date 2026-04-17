<?php

namespace App\Models;

use Illuminate\Database\Eloquent\SoftDeletes;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

#[Fillable(['code', 'name', 'supply_id'])]
class SupplyCharacteristic extends Model
{
    use SoftDeletes;



    public function supply(): BelongsTo
    {
        return $this->belongsTo(Supply::class);
    }
}
