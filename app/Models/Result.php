<?php

namespace App\Models;

use Illuminate\Database\Eloquent\SoftDeletes;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Relations\HasMany;

#[Fillable(['code', 'name'])]
class Result extends Model
{
    use SoftDeletes, HasFactory;

    public function revisions(): HasMany
    {
        return $this->hasMany(Revision::class);
    }

    public function reproductiveDiagnostics(): HasMany
    {
        return $this->hasMany(ReproductiveDiagnostic::class);
    }
}
