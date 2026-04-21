<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class InventoryMovementSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $productId = DB::table('products')->first()->id;

        $movements = [
            [
                'product_id' => $productId,
                'type' => 'income',
                'made_at' => now(),
                'attributes' => json_encode(['batch_no' => 'B-2026-001', 'supplier' => 'AgroGlobal']),
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ];

        foreach ($movements as $movement) {
            DB::table('product_movements')->insert($movement);
        }

        $supplyId = DB::table('supplies')->first()->id;
        $supplyMovements = [
            [
                'supply_id' => $supplyId,
                'type' => 'income',
                'made_at' => now(),
                'attributes' => json_encode(['batch_no' => 'S-2026-001', 'expiry' => '2027-12-31']),
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ];

        foreach ($supplyMovements as $move) {
            DB::table('supply_movements')->insert($move);
        }
    }
}
