<?php

namespace App\Repositories;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;

interface EpisodesRepository
{
    public function update(Request $request, int $seasonId);
    public function increaseEpisodes(int $seriesId, Collection $seasons, int $episodesPerSeason, int $newEpisodesPerSeason);
    public function decreaseEpisodes(int $seriesId, Collection $seasons, int $episodesPerSeason, int $newEpisodesPerSeason);
}