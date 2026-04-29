<?php

namespace App\Models;

use Illuminate\Database\Eloquent\SoftDeletes;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use LaravelLang\Publisher\Concerns\Has;

#[Fillable(['name', 'path', 'description', 'livestock_id'])]
class Image extends Model
{
    use SoftDeletes, HasFactory;

    public function livestock(): BelongsTo
    {
        return $this->belongsTo(Livestock::class);
    }
}
