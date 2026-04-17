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

        // movements_in_lots
        DB::table('movements_in_lots')->insert([
            'batch_id' => $batchId,
            'livestock_id' => $livestockId,
            'date' => now()->toDateString(),
            'raison' => 'Agrupación por edad',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // revisions
        DB::table('revisions')->insert([
            'livestock_id' => $livestockId,
            'date_at' => now()->toDateString(),
            'comment' => 'Revision rutinaria ok',
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
            'date_at' => now()->toDateString(),
            'comment' => 'Presenta celo',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // reproductive_diagnostics
        DB::table('reproductive_diagnostics')->insert([
            'livestock_id' => $livestockId,
            'result_id' => $resultId,
            'date' => now()->toDateString(),
            'o_izq' => 1,
            'o_der' => 1,
            'u_izq' => 0,
            'u_der' => 0,
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }
}
