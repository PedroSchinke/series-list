<?php

namespace App\Listeners;

use App\Events\SeriesCreated as EventsSeriesCreated;
use App\Mail\SeriesCreated;
use App\Models\User;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Mail;

class EmailUserAboutSeriesCreated implements ShouldQueue
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
     * @param  object  $event
     * @return void
     */
    public function handle(EventsSeriesCreated $event)
    {
        $usersList = User::all();
        foreach ($usersList as $index => $user) {
            $email = new SeriesCreated(
                $event->getSeriesName(),
                $event->getSeriesId(),
                $event->getSeriesSeasonsQty(),
                $event->getSeriesEpisodesPerSeason()
            );
            $when = now()->addSeconds($index * 2);
            Mail::to($user)->later($when, $email);
            // OR => Mail::to(Auth::user());
        }
    }
}
