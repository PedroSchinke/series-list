<?php

namespace App\Repositories;

use App\Models\Series;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;

interface EpisodesRepository
{
    public function update(Request $request, int $seasonId);
    public function increaseEpisodes(Series $series, Collection $seasons, int $episodesPerSeason, int $newEpisodesPerSeason);
    public function decreaseEpisodes(Series $series, Collection $seasons, int $episodesPerSeason, int $newEpisodesPerSeason);
}