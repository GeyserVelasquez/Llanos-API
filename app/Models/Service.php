<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphTo;

#[Fillable(['female_id', 'parental_type', 'parental_id', 'technique_id', 'service_type_id', 'comment', 'made_at'])]
class Service extends Model
{


    protected function casts(): array
    {
        return [
            'made_at' => 'date',
        ];
    }

    public function female(): BelongsTo
    {
        return $this->belongsTo(Livestock::class, 'female_id');
    }

    public function parental(): MorphTo
    {
        return $this->morphTo();
    }

    public function technique(): BelongsTo
    {
        return $this->belongsTo(Technique::class);
    }

    public function serviceType(): BelongsTo
    {
        return $this->belongsTo(ServiceType::class);
    }
}
