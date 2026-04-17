<?php

namespace App\Models;

use Illuminate\Database\Eloquent\SoftDeletes;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphTo;

#[Fillable(['batch_type', 'batch_id', 'technique_id', 'extraction_type_id', 'date', 'comments'])]
class Extraction extends Model
{
    use SoftDeletes;



    protected function casts(): array
    {
        return [
            'date' => 'date',
        ];
    }

    public function batch(): MorphTo
    {
        return $this->morphTo();
    }

    public function technique(): BelongsTo
    {
        return $this->belongsTo(Technique::class);
    }

    public function extractionType(): BelongsTo
    {
        return $this->belongsTo(ExtractionType::class);
    }
}
