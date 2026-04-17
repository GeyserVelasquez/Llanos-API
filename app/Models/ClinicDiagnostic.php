<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

#[Fillable(['code', 'name', 'attributes'])]
class ClinicDiagnostic extends Model
{


    protected function casts(): array
    {
        return [
            'attributes' => 'array',
        ];
    }

    public function clinicHistories(): BelongsToMany
    {
        return $this->belongsToMany(ClinicHistory::class, 'clinic_history_diagnostics');
    }
}
