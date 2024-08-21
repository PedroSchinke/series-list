<?php

namespace App\Listeners;

use App\Events\SeriesDestroyed;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Storage;

class DeleteSeriesCoverFile implements ShouldQueue
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  \App\Events\SeriesDestroyed  $event
     * @return void
     */
    public function handle(SeriesDestroyed $event)
    {
        Storage::disk('public')->delete($event->getCover());
    }
}
