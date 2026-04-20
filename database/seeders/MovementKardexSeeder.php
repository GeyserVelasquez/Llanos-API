<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class MovementKardexSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $livestockId = DB::table('livestock')->first()->id;
        $productId = DB::table('products')->first()->id;
        $inMovementTypeId = DB::table('product_movement_types')->where('code', 'IN')->first()->id;
        $outMovementTypeId = DB::table('product_movement_types')->where('code', 'OUT')->first()->id;

        // Sample Extraction for Event
        $techniqueId = DB::table('techniques')->first()->id;
        $extractionTypeId = DB::table('extraction_types')->first()->id;
        $semenBatchId = DB::table('semen_batches')->first()?->id;

        // If no semen batch exists, we can't easily seed extraction without more lookups.
        // Let's use ProductMovement as events for now as the user mentioned "el movimiento en productos etc"

        $productMovementId = DB::table('product_movements')->first()->id;

        $kardexEntries = [
            [
                'item_id' => $livestockId,
                'item_type' => 'App\Models\Livestock',
                'product_movement_type_id' => $inMovementTypeId,
                'quantity' => 1,
                'event_id' => $productMovementId,
                'event_type' => 'App\Models\ProductMovement',
                'date' => now(),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'item_id' => $productId,
                'item_type' => 'App\Models\Product',
                'product_movement_type_id' => $outMovementTypeId,
                'quantity' => 5,
                'event_id' => $productMovementId,
                'event_type' => 'App\Models\ProductMovement',
                'date' => now(),
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ];

        foreach ($kardexEntries as $entry) {
            DB::table('movement_kardex')->insert($entry);
        }
    }
}
