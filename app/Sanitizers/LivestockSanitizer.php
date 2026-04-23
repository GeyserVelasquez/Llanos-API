<?php

namespace App\Sanitizers;

use App\Models\Livestock;

class LivestockSanitizer extends Sanitizer
{

    /**
     * Create a new class instance.
     */
    public function __construct()
    {
        //
    }

    public function sanitize(Livestock $livestock): void
    {
        $this->sanitizeTitsValueByAnimalCategory($livestock);

        $this->capitalizeLivestockName($livestock);
    }

    private function sanitizeTitsValueByAnimalCategory(Livestock $livestock): void
    {
        if ($livestock->animal_category) {
            return;
        }

        if ($livestock->animal_category->isMale()) {
            $livestock->tits = 0;
        }
    }

    public function capitalizeLivestockName(Livestock $livestock): void
    {
        if ($livestock->name) {
            $livestock->name = ucfirst(strtolower($livestock->name));
        }
    }

}
