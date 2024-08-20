<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class SeriesCreated extends Mailable
{
    use Queueable, SerializesModels;
    public string $seriesName;
    public int $seriesId;
    public int $seasonsQty;
    public int $episodesPerSeason;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(string $seriesName, int $seriesId, int $seasonsQty, int $episodesPerSeason)
    {
        $this->seriesName =$seriesName;
        $this->seriesId = $seriesId;
        $this->seasonsQty = $seasonsQty;
        $this->episodesPerSeason = $episodesPerSeason;
        $this->subject = "Series $seriesName created successfully!";
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->markdown('mail.series-created');
    }
}
