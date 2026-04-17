<?php

namespace App\Models;

use Illuminate\Database\Eloquent\SoftDeletes;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

#[Fillable([
    'date', 'milking_type_id', 'morning_weight', 'afternoon_weight',
    'total_weight', 'mother_history_id', 'is_active', 'livestock_id'
])]
class Milking extends Model
{
    use SoftDeletes;



    protected function casts(): array
    {
        return [
            'date' => 'date',
            'is_active' => 'integer',
        ];
    }

    public function milkingType(): BelongsTo
    {
        return $this->belongsTo(MilkingType::class);
    }

    public function motherHistory(): BelongsTo
    {
        return $this->belongsTo(ClinicHistory::class, 'mother_history_id');
    }

    public function livestock(): BelongsTo
    {
        return $this->belongsTo(Livestock::class);
    }
}
