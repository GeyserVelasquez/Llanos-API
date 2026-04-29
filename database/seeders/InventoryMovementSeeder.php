<?php

namespace Database\Seeders;

use App\Enums\MovementType;
use App\Models\Product;
use App\Models\ProductMovement;
use App\Models\Supply;
use App\Models\SupplyMovement;
use Illuminate\Database\Seeder;

class InventoryMovementSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $product = Product::first();

        $productMovements = [
            [
                'product_id' => $product->id,
                'type' => MovementType::INCOME,
                'made_at' => now(),
                'attributes' => ['batch_no' => 'B-2026-001', 'supplier' => 'AgroGlobal'],
            ],
        ];

        foreach ($productMovements as $movement) {
            ProductMovement::create($movement);
        }

        $supply = Supply::first();
        $supplyMovements = [
            [
                'supply_id' => $supply->id,
                'type' => MovementType::INCOME,
                'made_at' => now(),
                'attributes' => ['batch_no' => 'S-2026-001', 'expiry' => '2027-12-31'],
            ],
        ];

        foreach ($supplyMovements as $move) {
            SupplyMovement::create($move);
        }
    }
}
