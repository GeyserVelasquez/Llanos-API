<?php

namespace App\Models;

use Illuminate\Database\Eloquent\SoftDeletes;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

#[Fillable(['date', 'weight', 'height', 'comment', 'growth_type_id', 'livestock_id'])]
class Growth extends Model
{
    use SoftDeletes;



    protected function casts(): array
    {
        return [
            'date' => 'date',
        ];
    }

    public function growthType(): BelongsTo
    {
        return $this->belongsTo(GrowthType::class);
    }

    public function livestock(): BelongsTo
    {
        return $this->belongsTo(Livestock::class);
    }
}
