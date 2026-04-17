<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\MorphMany;

#[Fillable([
    'brand_number', 'electronic_code', 'name', 'entry_date', 'birth_date',
    'general_comment', 'tits', 'is_enabled', 'is_alive', 'entry_cause_id',
    'state_id', 'animal_category_id', 'breed_id', 'color_id', 'classification_id',
    'owner_id', 'technique_id', 'batch_id', 'father_id', 'mother_id',
    'adoptive_mother_id', 'receiving_mother_id'
])]
class Livestock extends Model
{


    protected $table = 'livestock';

    protected function casts(): array
    {
        return [
            'entry_date' => 'date',
            'birth_date' => 'date',
            'is_enabled' => 'boolean',
            'is_alive' => 'boolean',
        ];
    }

    public function entryCause(): BelongsTo
    {
        return $this->belongsTo(EntryCause::class);
    }

    public function state(): BelongsTo
    {
        return $this->belongsTo(State::class);
    }

    public function animalCategory(): BelongsTo
    {
        return $this->belongsTo(AnimalCategory::class);
    }

    public function breed(): BelongsTo
    {
        return $this->belongsTo(Breed::class);
    }

    public function color(): BelongsTo
    {
        return $this->belongsTo(Color::class);
    }

    public function classification(): BelongsTo
    {
        return $this->belongsTo(Classification::class);
    }

    public function owner(): BelongsTo
    {
        return $this->belongsTo(Owner::class);
    }

    public function technique(): BelongsTo
    {
        return $this->belongsTo(Technique::class);
    }

    public function batch(): BelongsTo
    {
        return $this->belongsTo(Batch::class);
    }

    public function father(): BelongsTo
    {
        return $this->belongsTo(Livestock::class, 'father_id');
    }

    public function mother(): BelongsTo
    {
        return $this->belongsTo(Livestock::class, 'mother_id');
    }

    public function adoptiveMother(): BelongsTo
    {
        return $this->belongsTo(Livestock::class, 'adoptive_mother_id');
    }

    public function receivingMother(): BelongsTo
    {
        return $this->belongsTo(Livestock::class, 'receiving_mother_id');
    }

    public function childrenAsFather(): HasMany
    {
        return $this->hasMany(Livestock::class, 'father_id');
    }

    public function childrenAsMother(): HasMany
    {
        return $this->hasMany(Livestock::class, 'mother_id');
    }

    public function semenBatches(): HasMany
    {
        return $this->hasMany(SemenBatch::class);
    }

    public function embrionBatchesAsMother(): HasMany
    {
        return $this->hasMany(EmbrionBatch::class, 'mother_id');
    }

    public function embrionBatchesAsFather(): HasMany
    {
        return $this->hasMany(EmbrionBatch::class, 'father_id');
    }

    public function clinicHistories(): HasMany
    {
        return $this->hasMany(ClinicHistory::class);
    }

    public function births(): HasMany
    {
        return $this->hasMany(Birth::class, 'mother_id');
    }

    public function newborns(): HasMany
    {
        return $this->hasMany(Newborn::class);
    }

    public function servicesAsFemale(): HasMany
    {
        return $this->hasMany(Service::class, 'female_id');
    }

    public function servicesAsParental(): MorphMany
    {
        return $this->morphMany(Service::class, 'parental');
    }

    public function growths(): HasMany
    {
        return $this->hasMany(Growth::class);
    }

    public function aborts(): HasMany
    {
        return $this->hasMany(Abort::class);
    }

    public function milkings(): HasMany
    {
        return $this->hasMany(Milking::class);
    }

    public function images(): HasMany
    {
        return $this->hasMany(Image::class);
    }

    public function comments(): HasMany
    {
        return $this->hasMany(Comment::class);
    }

    public function outcomes(): HasMany
    {
        return $this->hasMany(Outcome::class);
    }

    public function movementsInLots(): HasMany
    {
        return $this->hasMany(MovementInLot::class);
    }

    public function revisions(): HasMany
    {
        return $this->hasMany(Revision::class);
    }

    public function teasings(): HasMany
    {
        return $this->hasMany(Teasing::class);
    }

    public function reproductiveDiagnostics(): HasMany
    {
        return $this->hasMany(ReproductiveDiagnostic::class);
    }

    public function certificates(): BelongsToMany
    {
        return $this->belongsToMany(Certificate::class, 'livestock_certificates');
    }

    public function products(): MorphMany
    {
        return $this->morphMany(Product::class, 'origin');
    }
}
