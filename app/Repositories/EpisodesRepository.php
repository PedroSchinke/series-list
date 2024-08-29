<?php

namespace App\Repositories;

use App\Models\Series;
use Illuminate\Http\Request;

interface EpisodesRepository
{
    public function update(Request $request, int $seasonId);
    public function increaseEpisodes(Series $series, int $episodesPerSeason, int $newEpisodesPerSeason);
    public function decreaseEpisodes(Series $series, int $episodesPerSeason, int $newEpisodesPerSeason);
}