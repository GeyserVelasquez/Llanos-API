<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class LookUpTablesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $tables = [
            'entry_causes' => [
                ['code' => 'BORN', 'name' => 'Nacimiento'],
                ['code' => 'PURCHASE', 'name' => 'Compra'],
                ['code' => 'GIFT', 'name' => 'Regalo'],
                ['code' => 'TRANSFER', 'name' => 'Traspaso'],
            ],
            'states' => [
                ['code' => 'HEALTHY', 'name' => 'Sano'],
                ['code' => 'SICK', 'name' => 'Enfermo'],
                ['code' => 'TREATMENT', 'name' => 'En Tratamiento'],
                ['code' => 'QUARANTINE', 'name' => 'En Cuarentena'],
            ],
            'classification' => [
                ['code' => 'GOOD', 'name' => 'Bueno'],
                ['code' => 'REGULAR', 'name' => 'Regular'],
                ['code' => 'BAD', 'name' => 'Malo'],
            ],
            'animal_categories' => [
                ['code' => 'BULL', 'name' => 'Toro'],
                ['code' => 'COW', 'name' => 'Vaca'],
                ['code' => 'CALF', 'name' => 'Ternero'],
                ['code' => 'HEIFER', 'name' => 'Novilla'],
                ['code' => 'STEER', 'name' => 'Novillo'],
                ['code' => 'MALECALF', 'name' => 'Becerro'],
                ['code' => 'FEMALECALF', 'name' => 'Becerra'],
            ],
            'colors' => [
                ['code' => 'WHITE', 'name' => 'Blanco'],
                ['code' => 'BLACK', 'name' => 'Negro'],
                ['code' => 'BROWN', 'name' => 'Castaño'],
                ['code' => 'SPOTTED', 'name' => 'Manchado'],
                ['code' => 'GREY', 'name' => 'Gris'],
            ],
            'breeds' => [
                ['code' => 'HOLSTEIN', 'name' => 'Holstein'],
                ['code' => 'JERSEY', 'name' => 'Jersey'],
                ['code' => 'ANGUS', 'name' => 'Angus'],
                ['code' => 'BRAHMAN', 'name' => 'Brahman'],
                ['code' => 'ZEBU', 'name' => 'Cebú'],
            ],
            'outcome_types' => [
                ['code' => 'SALE', 'name' => 'Venta'],
                ['code' => 'DEATH', 'name' => 'Muerte'],
                ['code' => 'SLAUGHTER', 'name' => 'Sacrificio'],
                ['code' => 'TRANSFER', 'name' => 'Traspaso'],
                ['code' => 'THEFT', 'name' => 'Robo'],
            ],
            'product_types' => [
                ['code' => 'MILK', 'name' => 'Leche'],
                ['code' => 'MEAT', 'name' => 'Carne'],
                ['code' => 'SEMEN', 'name' => 'Semen'],
                ['code' => 'EMBRYO', 'name' => 'Embrión'],
            ],
            'product_movement_types' => [
                ['code' => 'IN', 'name' => 'Entrada'],
                ['code' => 'OUT', 'name' => 'Salida'],
                ['code' => 'ADJUST', 'name' => 'Ajuste'],
            ],
            'supply_types' => [
                ['code' => 'MEDICINE', 'name' => 'Medicamento'],
                ['code' => 'FEED', 'name' => 'Alimento'],
                ['code' => 'TOOL', 'name' => 'Herramienta'],
                ['code' => 'VACCINE', 'name' => 'Vacuna'],
            ],
            'results' => [
                ['code' => 'POSITIVE', 'name' => 'Positivo'],
                ['code' => 'NEGATIVE', 'name' => 'Negativo'],
                ['code' => 'PENDING', 'name' => 'Pendiente'],
                ['code' => 'UNKNOWN', 'name' => 'Desconocido'],
            ],
            'revision_types' => [
                ['code' => 'GENERAL', 'name' => 'General'],
                ['code' => 'REPRODUCTIVE', 'name' => 'Reproductiva'],
                ['code' => 'CLINICAL', 'name' => 'Clínica'],
                ['code' => 'POST-MORTEM', 'name' => 'Post-mortem'],
            ],
            'embrion_extraction_types' => [
                ['code' => 'SURGICAL', 'name' => 'Quirúrgica'],
                ['code' => 'NON-SURGICAL', 'name' => 'No Quirúrgica'],
            ],
            'milking_types' => [
                ['code' => 'MANUAL', 'name' => 'Manual'],
                ['code' => 'MECHANICAL', 'name' => 'Mecánica'],
            ],
            'abort_types' => [
                ['code' => 'SPONTANEOUS', 'name' => 'Espontáneo'],
                ['code' => 'INDUCED', 'name' => 'Inducido'],
                ['code' => 'ACCIDENTAL', 'name' => 'Accidental'],
            ],
            'growth_types' => [
                ['code' => 'BIRTH', 'name' => 'Al Nacer'],
                ['code' => 'GENERAL', 'name' => 'General'],
                ['code' => 'POSTBIRTH', 'name' => 'Post Parto'],
            ],
            'service_types' => [
                ['code' => 'NATURAL', 'name' => 'Monta Natural'],
                ['code' => 'AI', 'name' => 'Inseminación Artificial'],
                ['code' => 'TE', 'name' => 'Transferencia de Embriones'],
            ],
            'birth_types' => [
                ['code' => 'SINGLE', 'name' => 'Simple'],
                ['code' => 'MULTIPLE', 'name' => 'Múltiple'],
                ['code' => 'DYSTOCIC', 'name' => 'Distócico'],
            ],
            'newborn_types' => [
                ['code' => 'ALIVE', 'name' => 'Vivo'],
                ['code' => 'STILLBORN', 'name' => 'Muerto al nacer'],
                ['code' => 'WEAK', 'name' => 'Débil'],
            ],
            'extraction_types' => [
                ['code' => 'ASPIR', 'name' => 'Aspiracion'],
                ['code' => 'RECOL', 'name' => 'Recolleción'],
            ],
            'herds' => [
                ['code' => 'MAIN', 'name' => 'Hato Principal'],
                ['code' => 'NORTH', 'name' => 'Hato Norte'],
                ['code' => 'SOUTH', 'name' => 'Hato Sur'],
            ],
            'techniques' => [
                ['code' => 'V-14789456', 'name' => 'Técnico Principal', 'telephone' => '+584123456789'],
                ['code' => 'V-28124536', 'name' => 'Veterinario Senior', 'telephone' => '+584227558955'],
            ],
        ];

        foreach ($tables as $table => $rows) {
            foreach ($rows as $row) {
                DB::table($table)->updateOrInsert(
                    ['code' => $row['code']],
                    array_merge($row, ['created_at' => now(), 'updated_at' => now()])
                );
            }
        }
    }
}
