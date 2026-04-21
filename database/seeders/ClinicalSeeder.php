<?php

namespace Database\Seeders;

use App\Models\ClinicalTreatment;
use App\Models\ClinicDiagnostic;
use Illuminate\Database\Seeder;

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
            ClinicDiagnostic::updateOrCreate(['code' => $diag['code']], $diag);
        }

        $treatments = [
            ['code' => 'ANTI', 'name' => 'Antibiótico'],
            ['code' => 'VACC', 'name' => 'Vacunación'],
            ['code' => 'DESP', 'name' => 'Desparasitación'],
            ['code' => 'VITM', 'name' => 'Vitaminas'],
        ];

        foreach ($treatments as $treat) {
            ClinicalTreatment::updateOrCreate(['code' => $treat['code']], $treat);
        }
    }
}
