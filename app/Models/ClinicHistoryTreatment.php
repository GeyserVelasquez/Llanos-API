<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

#[Fillable(['clinic_history_id', 'clinical_treatment_id'])]
class ClinicHistoryTreatment extends Model
{


    public function clinicHistory(): BelongsTo
    {
        return $this->belongsTo(ClinicHistory::class);
    }

    public function clinicalTreatment(): BelongsTo
    {
        return $this->belongsTo(ClinicalTreatment::class);
    }
}
