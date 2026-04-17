<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Relations\HasMany;

#[Fillable(['code', 'name', 'telephone'])]
class Owner extends Model
{


    public function livestock(): HasMany
    {
        return $this->hasMany(Livestock::class);
    }
}
