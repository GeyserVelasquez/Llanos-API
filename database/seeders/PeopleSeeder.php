<?php

namespace Database\Seeders;

use App\Models\Owner;
use Illuminate\Database\Seeder;

class PeopleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $owners = [
            ['code' => 'V-12345678', 'name' => 'Juan Pérez', 'telephone' => '+584141112233'],
            ['code' => 'V-87654321', 'name' => 'María García', 'telephone' => '+584124445566'],
            ['code' => 'J-123456789', 'name' => 'Agropecuaria El Sol, C.A.', 'telephone' => '+582129998877'],
        ];

        foreach ($owners as $owner) {
            Owner::updateOrCreate(['code' => $owner['code']], $owner);
        }
    }
}
