<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class LivestockSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $entryCauseId = DB::table('entry_causes')->where('code', 'BORN')->first()->id;
        $stateId = DB::table('states')->where('code', 'HEALTHY')->first()->id;
        $animalCategoryId = DB::table('animal_categories')->where('code', 'COW')->first()->id;
        $breedId = DB::table('breeds')->where('code', 'HOLSTEIN')->first()->id;
        $colorId = DB::table('colors')->where('code', 'WHITE')->first()->id;
        $classificationId = DB::table('classifications')->where('code', 'GOOD')->first()->id;
        $ownerId = DB::table('owners')->first()->id;
        $techniqueId = DB::table('techniques')->first()->id;
        $batchId = DB::table('batches')->first()->id;

        $animals = [
            [
                'brand_number' => 'A-001',
                'name' => 'Lola',
                'entry_date' => now(),
                'birth_date' => now()->subYears(3),
                'entry_cause_id' => $entryCauseId,
                'state_id' => $stateId,
                'animal_category_id' => $animalCategoryId,
                'breed_id' => $breedId,
                'color_id' => $colorId,
                'classification_id' => $classificationId,
                'owner_id' => $ownerId,
                'technique_id' => $techniqueId,
                'batch_id' => $batchId,
            ],
            [
                'brand_number' => 'A-002',
                'name' => 'Clarabella',
                'entry_date' => now(),
                'birth_date' => now()->subYears(2),
                'entry_cause_id' => $entryCauseId,
                'state_id' => $stateId,
                'animal_category_id' => $animalCategoryId,
                'breed_id' => $breedId,
                'color_id' => $colorId,
                'classification_id' => $classificationId,
                'owner_id' => $ownerId,
                'technique_id' => $techniqueId,
                'batch_id' => $batchId,
            ],
        ];

        foreach ($animals as $animal) {
            DB::table('livestock')->updateOrInsert(['brand_number' => $animal['brand_number']], array_merge($animal, ['created_at' => now(), 'updated_at' => now()]));
        }
    }
}
