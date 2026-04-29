<?php

namespace App\Models;

use Illuminate\Database\Eloquent\SoftDeletes;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

#[Fillable(['birth_id', 'newborn_type_id', 'livestock_id'])]
class Newborn extends Model
{
    use SoftDeletes;



    public function birth(): BelongsTo
    {
        return $this->belongsTo(Birth::class);
    }

    public function newbornType(): BelongsTo
    {
        return $this->belongsTo(NewbornType::class);
    }

    public function livestock(): BelongsTo
    {
        return $this->belongsTo(Livestock::class);
    }
}
