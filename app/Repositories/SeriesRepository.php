<?php

namespace App\Repositories;

use App\Http\Requests\SeriesFormRequest;
use App\Models\Series;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Http\Request;

interface SeriesRepository
{
    public function getAll(Request $request): LengthAwarePaginator;
    public function add(SeriesFormRequest $request): Series;
    public function updateCategories(Series $series, SeriesFormRequest $request);
}