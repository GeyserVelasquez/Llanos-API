<?php

namespace App\Models;

use Illuminate\Database\Eloquent\SoftDeletes;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

#[Fillable(['date_at', 'comment', 'livestock_id', 'technique_id'])]
class Teasing extends Model
{
    use SoftDeletes;


    protected function casts(): array
    {
        return [
            'date_at' => 'date',
        ];
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
