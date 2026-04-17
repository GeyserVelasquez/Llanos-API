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
        $movementTypeId = DB::table('product_movement_types')->where('code', 'IN')->first()->id;

        $movements = [
            [
                'product_id' => $productId,
                'product_movement_type_id' => $movementTypeId,
                'made_at' => now(),
                'quantity' => 100,
                'attributes' => json_encode(['batch_no' => 'B-2026-001', 'supplier' => 'AgroGlobal']),
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ];

        foreach ($movements as $movement) {
            DB::table('product_movements')->insert($movement);
        }

        $supplyId = DB::table('supplies')->first()->id;
        $characteristics = [
            ['code' => 'EXP-DATE', 'name' => 'Fecha de Vencimiento', 'supply_id' => $supplyId],
            ['code' => 'STORAGE', 'name' => 'Condición de Almacenamiento', 'supply_id' => $supplyId],
        ];

        foreach ($characteristics as $char) {
            DB::table('supply_characteristics')->updateOrInsert(['code' => $char['code']], array_merge($char, ['created_at' => now(), 'updated_at' => now()]));
        }
    }
}
