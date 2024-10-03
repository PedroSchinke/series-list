<?php

namespace App\Repositories;

use Illuminate\Http\Request;

interface UsersRepository
{
    public function favoriteSeries(int $seriesId);
    public function rateSeries(int $seriesId, Request $request);
    public function getSeriesRating(int $seriesId);
}
