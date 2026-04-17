<?php

namespace App\Models;

use Illuminate\Database\Eloquent\SoftDeletes;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

#[Fillable(['date', 'o_izq', 'o_der', 'u_izq', 'u_der', 'result_id', 'livestock_id'])]
class ReproductiveDiagnostic extends Model
{
    use SoftDeletes;



    protected function casts(): array
    {
        return [
            'date' => 'date',
            'o_izq' => 'integer',
            'o_der' => 'integer',
            'u_izq' => 'integer',
            'u_der' => 'integer',
        ];
    }

    public function result(): BelongsTo
    {
        return $this->belongsTo(Result::class);
    }

    public function livestock(): BelongsTo
    {
        return $this->belongsTo(Livestock::class);
    }
}
