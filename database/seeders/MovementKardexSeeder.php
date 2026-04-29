<?php

namespace Database\Seeders;

use App\Enums\MovementType;
use App\Models\Livestock;
use App\Models\MovementKardex;
use App\Models\Product;
use App\Models\ProductMovement;
use Illuminate\Database\Seeder;

class MovementKardexSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $livestock = Livestock::first();
        $product = Product::first();
        $productMovement = ProductMovement::first();

        $kardexEntries = [
            [
                'item_id' => $livestock->id,
                'item_type' => Livestock::class,
                'type' => MovementType::INCOME,
                'quantity' => 1,
                'event_id' => $productMovement->id,
                'event_type' => ProductMovement::class,
                'date' => now(),
            ],
            [
                'item_id' => $product->id,
                'item_type' => Product::class,
                'type' => MovementType::OUTCOME,
                'quantity' => 5,
                'event_id' => $productMovement->id,
                'event_type' => ProductMovement::class,
                'date' => now(),
            ],
        ];

        foreach ($kardexEntries as $entry) {
            MovementKardex::create($entry);
        }
    }
}
