<?php

namespace App\Repositories;

use App\Models\Series;

interface SeasonsRepository
{
    public function increaseSeasons(Series $series, int $seasonsQty, int $newSeasonsQty, int $episodesPerSeason);
    public function decreaseSeasons(Series $series, int $seasonsQty, int $newSeasonsQty);
}