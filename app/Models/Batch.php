<?php

namespace App\Models;

use Illuminate\Database\Eloquent\SoftDeletes;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphMany;

#[Fillable(['code', 'name', 'herd_id'])]
class Batch extends Model
{
    use SoftDeletes, HasFactory;

    public function herd(): BelongsTo
    {
        return $this->belongsTo(Herd::class);
    }

    public function livestock(): HasMany
    {
        return $this->hasMany(Livestock::class);
    }

    public function batchMovement(): HasMany
    {
        return $this->hasMany(BatchMovement::class);
    }

    public function extractions(): MorphMany
    {
        return $this->morphMany(Extraction::class, 'batch');
    }
}
