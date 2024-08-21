<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\SeriesFormRequest;
use App\Models\Series;
use App\Repositories\SeriesRepository;

class SeriesController extends Controller
{
    private SeriesRepository $repository;

    public function __construct(SeriesRepository $repository)
    {
        $this->repository = $repository;
    }
    
    public function index()
    {
        return Series::all();
    }

    public function store(SeriesFormRequest $request)
    {
        return response()
            ->json($this->repository->add($request), 201);
    }

    public function show(int $series)
    {
        $series = Series::whereId($series)
            ->with('seasons.episodes')
            ->first();
        return $series;
    }

    public function update(int $seriesId, SeriesFormRequest $request)
    {
        // $series->fill($request->all());
        // $series->save();

        // $series = Series::find($seriesId);

        // $series->update($request->all());

        Series::where('id', $seriesId)->update($request->all());

        return response()->noContent();
    }

    public function destroy(int $series)
    {
        Series::destroy($series);

        return response()->noContent();
    }
}