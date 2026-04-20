<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ClinicalSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $diagnostics = [
            ['code' => 'MAST', 'name' => 'Mastitis'],
            ['code' => 'BRUC', 'name' => 'Brucelosis'],
            ['code' => 'FIEB', 'name' => 'Fiebre Aftosa'],
            ['code' => 'PARS', 'name' => 'Parásitos'],
        ];

        foreach ($diagnostics as $diag) {
            DB::table('clinic_diagnostics')->updateOrInsert(['code' => $diag['code']], array_merge($diag, ['created_at' => now(), 'updated_at' => now()]));
        }

        $treatments = [
            ['code' => 'ANTI', 'name' => 'Antibiótico'],
            ['code' => 'VACC', 'name' => 'Vacunación'],
            ['code' => 'DESP', 'name' => 'Desparasitación'],
            ['code' => 'VITM', 'name' => 'Vitaminas'],
        ];

        foreach ($treatments as $treat) {
            DB::table('clinical_treatments')->updateOrInsert(['code' => $treat['code']], array_merge($treat, ['created_at' => now(), 'updated_at' => now()]));
        }
    }
}
