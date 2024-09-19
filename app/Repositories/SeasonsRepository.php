<?php

namespace App\Repositories;

use App\Http\Requests\SeriesFormRequest;
use App\Models\Series;

interface SeasonsRepository
{
    public function increaseSeasons(Series $series, SeriesFormRequest $request);
    public function decreaseSeasons(Series $series, SeriesFormRequest $request);
}