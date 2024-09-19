<?php

namespace App\Observers;

use App\Models\Season;
use App\Models\Series;

class SeasonObserver
{
    /**
     * Handle the Season "created" event.
     *
     * @param  \App\Models\Season  $season
     * @return void
     */
    public function created(Season $season)
    {
        $this->updateSeasonsQty($season->series);
    }

    /**
     * Handle the Season "updated" event.
     *
     * @param  \App\Models\Season  $season
     * @return void
     */
    public function updated(Season $season)
    {
        //
    }

    /**
     * Handle the Season "deleted" event.
     *
     * @param  \App\Models\Season  $season
     * @return void
     */
    public function deleted(Season $season)
    {
        $this->updateSeasonsQty($season->series);
    }

    /**
     * Handle the Season "restored" event.
     *
     * @param  \App\Models\Season  $season
     * @return void
     */
    public function restored(Season $season)
    {
        //
    }

    /**
     * Handle the Season "force deleted" event.
     *
     * @param  \App\Models\Season  $season
     * @return void
     */
    public function forceDeleted(Season $season)
    {
        //
    }

    protected function updateSeasonsQty(Series $series)
    {
        $seasons_qty = Season::where('series_id', $series->id)->count();
        $series->update([
            'seasons_qty' => $seasons_qty
        ]);
    }
}
