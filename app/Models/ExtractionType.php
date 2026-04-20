<?php

namespace App\Models;

use Illuminate\Database\Eloquent\SoftDeletes;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Relations\HasMany;

#[Fillable(['code', 'name'])]
class ExtractionType extends Model
{
    use SoftDeletes,HasFactory;



    public function extractions(): HasMany
    {
        return $this->hasMany(Extraction::class);
    }
}
