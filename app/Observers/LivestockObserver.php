<?php

namespace App\Observers;

use App\Models\Livestock;

class LivestockObserver
{
    /**
     * Handle the Livestock "created" event.
     */
    public function created(Livestock $livestock): void
    {
        //
    }

    /**
     * Handle the Livestock "updated" event.
     */
    public function updated(Livestock $livestock): void
    {
        //
    }

    /**
     * Handle the Livestock "deleted" event.
     */
    public function deleted(Livestock $livestock): void
    {
        //
    }

    /**
     * Handle the Livestock "restored" event.
     */
    public function restored(Livestock $livestock): void
    {
        //
    }

    /**
     * Handle the Livestock "force deleted" event.
     */
    public function forceDeleted(Livestock $livestock): void
    {
        //
    }
}
