<?php

namespace Database\Seeders;

use App\Models\Batch;
use App\Models\BatchMovement;
use App\Models\Livestock;
use App\Models\Result;
use App\Models\Revision;
use App\Models\RevisionType;
use App\Models\Teasing;
use App\Models\Technique;
use Illuminate\Database\Seeder;

class LivestockEventSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $livestock = Livestock::first();
        $batch = Batch::first();
        $technique = Technique::first();
        $result = Result::where('code', 'POSITIVE')->first();
        $revisionType = RevisionType::where('code', 'GENERAL')->first();

        // batch_movements
        BatchMovement::create([
            'batch_id' => $batch->id,
            'livestock_id' => $livestock->id,
            'made_at' => now(),
            'attributes' => ['reason' => 'Agrupación por edad'],
        ]);

        // revisions
        Revision::create([
            'livestock_id' => $livestock->id,
            'made_at' => now(),
            'result_id' => $result->id,
            'revision_type_id' => $revisionType->id,
            'technique_id' => $technique->id,
        ]);

        // teasings
        Teasing::create([
            'livestock_id' => $livestock->id,
            'technique_id' => $technique->id,
            'detected_at' => now(),
        ]);
    }
}
