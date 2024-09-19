<?php

namespace App\Repositories;

use App\Models\Season;
use App\Models\Series;
use Illuminate\Http\Request;

interface EpisodesRepository
{
    public function get(Season $season);
    public function update(Request $request, int $seasonId);
    public function increaseEpisodes(Series $series, int $episodes_per_season, int $newEpisodesPerSeason);
    public function decreaseEpisodes(Series $series, int $episodes_per_season, int $newEpisodesPerSeason);
}