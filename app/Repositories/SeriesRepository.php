<?php

namespace App\Repositories;

use App\Http\Requests\SeriesFormRequest;
use App\Models\Series;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

interface SeriesRepository
{
    public function getAll(int $itemsPerPage): LengthAwarePaginator;
    public function add(SeriesFormRequest $request): Series;
}