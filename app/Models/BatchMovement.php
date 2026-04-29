<?php

namespace App\Models;

use Illuminate\Database\Eloquent\SoftDeletes;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

#[Fillable(['batch_id', 'made_at', 'attributes', 'livestock_id'])]
class BatchMovement extends Model
{
    use SoftDeletes, HasFactory;

    protected $table = 'batch_movements';

    protected function casts(): array
    {
        return [
            'made_at' => 'date',
            'attributes' => 'json'
        ];
    }

    public function batch(): BelongsTo
    {
        return $this->belongsTo(Batch::class);
    }

    public function livestock(): BelongsTo
    {
        return $this->belongsTo(Livestock::class);
    }
}
