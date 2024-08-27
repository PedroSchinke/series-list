<?php

namespace App\Observers;

use App\Models\Series;
use Illuminate\Support\Facades\Storage;

class SeriesObserver
{
    /**
     * Handle the Series "created" event.
     *
     * @param  \App\Models\Series  $series
     * @return void
     */
    public function created(Series $series)
    {
        //
    }

    /**
     * Handle the Series "updated" event.
     *
     * @param  \App\Models\Series  $series
     * @return void
     */
    public function updated(Series $series)
    {
        //
    }

    /**
     * Handle the Series "deleted" event.
     *
     * @param  \App\Models\Series  $series
     * @return void
     */
    public function deleted(Series $series)
    {
        Storage::disk('public')->delete($series->cover);
    }

    /**
     * Handle the Series "restored" event.
     *
     * @param  \App\Models\Series  $series
     * @return void
     */
    public function restored(Series $series)
    {
        //
    }

    /**
     * Handle the Series "force deleted" event.
     *
     * @param  \App\Models\Series  $series
     * @return void
     */
    public function forceDeleted(Series $series)
    {
        Storage::disk('public')->delete($series->cover);
    }
}
