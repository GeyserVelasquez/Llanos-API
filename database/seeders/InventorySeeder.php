<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class InventorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $herdId = DB::table('herds')->first()->id;

        $batches = [
            ['code' => 'BATCH-001', 'name' => 'Lote de Engorde 1', 'herd_id' => $herdId],
            ['code' => 'BATCH-002', 'name' => 'Lote de Cría A', 'herd_id' => $herdId],
        ];

        foreach ($batches as $batch) {
            DB::table('batches')->updateOrInsert(['code' => $batch['code']], array_merge($batch, ['created_at' => now(), 'updated_at' => now()]));
        }

        $supplyTypeId = DB::table('supply_types')->where('code', 'MEDICINE')->first()->id;

        $supplies = [
            ['code' => 'OXIT-500', 'name' => 'Oxitetraciclina 500mg', 'quantity' => 100, 'supply_type_id' => $supplyTypeId],
            ['code' => 'IVEM-1', 'name' => 'Ivermectina 1%', 'quantity' => 50, 'supply_type_id' => $supplyTypeId],
        ];

        foreach ($supplies as $supply) {
            DB::table('supplies')->updateOrInsert(['code' => $supply['code']], array_merge($supply, ['created_at' => now(), 'updated_at' => now()]));
        }

        $productTypeId = DB::table('product_types')->where('code', 'MILK')->first()->id;

        $products = [
            [
                'code' => 'MILK-PREM',
                'name' => 'Leche Premium',
                'description' => 'Leche de alta calidad',
                'attributes' => json_encode(['fat_content' => '3.5%', 'grade' => 'A']),
                'product_type_id' => $productTypeId
            ],
        ];

        foreach ($products as $product) {
            DB::table('products')->updateOrInsert(['code' => $product['code']], array_merge($product, ['created_at' => now(), 'updated_at' => now()]));
        }
    }
}
