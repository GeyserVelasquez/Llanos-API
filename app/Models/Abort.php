<?php

namespace App\Models;

use Illuminate\Database\Eloquent\SoftDeletes;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

#[Fillable(['date', 'mother_history_id', 'abort_type_id', 'comment', 'livestock_id'])]
class Abort extends Model
{
    use SoftDeletes;



    protected function casts(): array
    {
        return [
            'date' => 'date',
        ];
    }

    public function motherHistory(): BelongsTo
    {
        return $this->belongsTo(ClinicHistory::class, 'mother_history_id');
    }

    public function abortType(): BelongsTo
    {
        return $this->belongsTo(AbortType::class);
    }

    public function livestock(): BelongsTo
    {
        return $this->belongsTo(Livestock::class);
    }
}
