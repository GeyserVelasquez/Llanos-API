<?php

namespace App\Models;

use Illuminate\Database\Eloquent\SoftDeletes;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

#[Fillable([
    'mother_id', 'mother_weight', 'birth_date', 'postbirth_revision_date',
    'birth_type_id', 'technique_id', 'comment', 'deceased_at', 'is_active'
])]
class Birth extends Model
{
    use SoftDeletes;



    protected function casts(): array
    {
        return [
            'birth_date' => 'date',
            'postbirth_revision_date' => 'date',
            'deceased_at' => 'date',
            'is_active' => 'integer',
        ];
    }

    public function mother(): BelongsTo
    {
        return $this->belongsTo(Livestock::class, 'mother_id');
    }

    public function birthType(): BelongsTo
    {
        return $this->belongsTo(BirthType::class);
    }

    public function technique(): BelongsTo
    {
        return $this->belongsTo(Technique::class);
    }

    public function newborns(): HasMany
    {
        return $this->hasMany(Newborn::class);
    }
}
