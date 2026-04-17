<?php

namespace App\Models;

use Illuminate\Database\Eloquent\SoftDeletes;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

#[Fillable(['text', 'date_at', 'is_active', 'livestock_id'])]
class Comment extends Model
{
    use SoftDeletes;



    protected function casts(): array
    {
        return [
            'date_at' => 'date',
            'is_active' => 'integer',
        ];
    }

    public function livestock(): BelongsTo
    {
        return $this->belongsTo(Livestock::class);
    }
}
