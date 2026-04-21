<?php

namespace Database\Seeders;

use App\Models\AnimalCategory;
use App\Models\Batch;
use App\Models\Breed;
use App\Models\Classification;
use App\Models\Color;
use App\Models\EntryCause;
use App\Models\Livestock;
use App\Models\Owner;
use App\Models\State;
use App\Models\Technique;
use Illuminate\Database\Seeder;

class LivestockSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $entryCause = EntryCause::where('code', 'BORN')->first();
        $state = State::where('code', 'HEALTHY')->first();
        $animalCategory = AnimalCategory::where('code', 'COW')->first();
        $breed = Breed::where('code', 'HOLSTEIN')->first();
        $color = Color::where('code', 'WHITE')->first();
        $classification = Classification::where('code', 'GOOD')->first();
        $owner = Owner::first();
        $technique = Technique::first();
        $batch = Batch::first();

        $animals = [
            [
                'brand_number' => 'A-001',
                'name' => 'Lola',
                'entry_date' => now(),
                'birth_date' => now()->subYears(3),
                'entry_cause_id' => $entryCause->id,
                'state_id' => $state->id,
                'animal_category_id' => $animalCategory->id,
                'breed_id' => $breed->id,
                'color_id' => $color->id,
                'classification_id' => $classification->id,
                'owner_id' => $owner->id,
                'technique_id' => $technique->id,
                'batch_id' => $batch->id,
            ],
            [
                'brand_number' => 'A-002',
                'name' => 'Clarabella',
                'entry_date' => now(),
                'birth_date' => now()->subYears(2),
                'entry_cause_id' => $entryCause->id,
                'state_id' => $state->id,
                'animal_category_id' => $animalCategory->id,
                'breed_id' => $breed->id,
                'color_id' => $color->id,
                'classification_id' => $classification->id,
                'owner_id' => $owner->id,
                'technique_id' => $technique->id,
                'batch_id' => $batch->id,
            ],
        ];

        foreach ($animals as $animal) {
            Livestock::updateOrCreate(['brand_number' => $animal['brand_number']], $animal);
        }
    }
}
