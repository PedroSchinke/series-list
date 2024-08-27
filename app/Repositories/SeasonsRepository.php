<?php

namespace App\Repositories;

interface SeasonsRepository
{
    public function increaseSeasons(int $seriesId, int $seasonsQty, int $newSeasonsQty, int $episodesPerSeason);
    public function decreaseSeasons(int $seriesId, int $seasonsQty, int $newSeasonsQty);
}