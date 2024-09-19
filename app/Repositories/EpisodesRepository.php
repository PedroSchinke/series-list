<?php

namespace App\Repositories;

use App\Http\Requests\SeriesFormRequest;
use App\Models\Season;
use App\Models\Series;
use Illuminate\Http\Request;

interface EpisodesRepository
{
    public function get(Season $season);
    public function update(Request $request, int $seasonId);
    public function increaseEpisodes(Series $series, SeriesFormRequest $request);
    public function decreaseEpisodes(Series $series, SeriesFormRequest $request);
}