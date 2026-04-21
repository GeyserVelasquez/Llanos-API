<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class LivestockEventSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $livestockId = DB::table('livestock')->first()->id;
        $batchId = DB::table('batches')->first()->id;
        $techniqueId = DB::table('techniques')->first()->id;
        $resultId = DB::table('results')->where('code', 'POSITIVE')->first()->id;
        $revisionTypeId = DB::table('revision_types')->where('code', 'GENERAL')->first()->id;
        $reproRevisionTypeId = DB::table('revision_types')->where('code', 'REPRODUCTIVE')->first()->id;

        // batch_movement_history
        DB::table('batch_movement_history')->insert([
            'batch_id' => $batchId,
            'livestock_id' => $livestockId,
            'made_at' => now()->toDateString(),
            'attributes' => json_encode(['reason' => 'Agrupación por edad']),
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // revisions
        DB::table('revisions')->insert([
            'livestock_id' => $livestockId,
            'made_at' => now()->toDateString(),
            'result_id' => $resultId,
            'revision_type_id' => $revisionTypeId,
            'technique_id' => $techniqueId,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // teasings
        DB::table('teasings')->insert([
            'livestock_id' => $livestockId,
            'technique_id' => $techniqueId,
            'detected_at' => now()->toDateString(),
            'description' => 'Presenta celo',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // reproductive_diagnostics (converted to revision)
        DB::table('revisions')->insert([
            'livestock_id' => $livestockId,
            'result_id' => $resultId,
            'made_at' => now()->toDateString(),
            'revision_type_id' => $reproRevisionTypeId,
            'technique_id' => $techniqueId,
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }
}
