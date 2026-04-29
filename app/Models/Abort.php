<?php

namespace App\Models;

use Illuminate\Database\Eloquent\SoftDeletes;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

#[Fillable(['made_at', 'abort_type_id', 'livestock_id', 'technique_id'])]
class Abort extends Model
{
    use SoftDeletes, HasFactory;



    protected function casts(): array
    {
        return [
            'made_at' => 'date',
        ];
    }

    public function abortType(): BelongsTo
    {
        return $this->belongsTo(AbortType::class);
    }

    public function livestock(): BelongsTo
    {
        return $this->belongsTo(Livestock::class);
    }

    public function technique(): BelongsTo
    {
        return $this->belongsTo(Technique::class);
    }

}
