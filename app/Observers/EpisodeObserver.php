<?php

namespace App\Observers;

use App\Models\Episode;
use App\Models\Series;

class EpisodeObserver
{
    /**
     * Handle the Episode "created" event.
     *
     * @param  \App\Models\Episode  $episode
     * @return void
     */
    public function created(Episode $episode)
    {
        $this->updateEpisodesPerSeason($episode->season->series);
    }

    /**
     * Handle the Episode "updated" event.
     *
     * @param  \App\Models\Episode  $episode
     * @return void
     */
    public function updated(Episode $episode)
    {
        //
    }

    /**
     * Handle the Episode "deleted" event.
     *
     * @param  \App\Models\Episode  $episode
     * @return void
     */
    public function deleted(Episode $episode)
    {
        $this->updateEpisodesPerSeason($episode->season->series);
    }

    /**
     * Handle the Episode "restored" event.
     *
     * @param  \App\Models\Episode  $episode
     * @return void
     */
    public function restored(Episode $episode)
    {
        //
    }

    /**
     * Handle the Episode "force deleted" event.
     *
     * @param  \App\Models\Episode  $episode
     * @return void
     */
    public function forceDeleted(Episode $episode)
    {
        //
    }

    protected function updateEpisodesPerSeason(Series $series)
    {
        $seasonCount = $series->seasons()->count();
        if ($seasonCount > 0) {
            $episodesPerSeason = $series->episodes()->count() / $seasonCount;
            $series->episodesPerSeason = (int) $episodesPerSeason;
            $series->save();
        }
    }
}
