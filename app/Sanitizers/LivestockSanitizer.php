<?php

namespace App\Sanitizers;

use App\Models\Livestock;

class LivestockSanitizer extends Sanitizer
{

    /**
     * Utility Class to sanitize Models' attributes.
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
        if (!$livestock->animal_category) {
            return;
        }

        if ($livestock->animal_category->isMale()) {
            $livestock->tits = 0;
        }
    }

    private function capitalizeLivestockName(Livestock $livestock): void
    {
        if ($livestock->name) {
            $livestock->name = ucfirst(strtolower($livestock->name));
        }
    }

}
