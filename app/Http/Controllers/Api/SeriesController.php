<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\SeriesFormRequest;
use App\Models\Series;
use App\Repositories\SeriesRepository;
use Illuminate\Http\Request;

class SeriesController extends Controller
{
    private SeriesRepository $repository;

    public function __construct(SeriesRepository $repository)
    {
        $this->repository = $repository;
    }
    
    public function index(Request $request)
    {
        $query = Series::query();

        if ($name = $request->input('name')) {
            $query->where('name', 'LIKE', '%' . $name . '%');
        }

        $series = $query->paginate(4);

        return $series;
    }

    public function store(SeriesFormRequest $request)
    {
        return response()
            ->json($this->repository->add($request), 201);
    }

    public function show(int $seriesId)
    {
        // $series = Series::whereId($seriesId)
        //     ->with('seasons.episodes')
        //     ->first();

        $series = Series::with('seasons.episodes')->find($seriesId);

        if ($series === null) {
            return response()->json(['message' => 'Series not found'], 404);
        }

        return $series;
    }

    public function update(int $seriesId, SeriesFormRequest $request)
    {
        // $series->fill($request->all());
        // $series->save();

        // $series = Series::find($seriesId);

        // $series->update($request->all());

        Series::where('id', $seriesId)->update([
            'name' => $request->input('name')
        ]);

        return response()->noContent();
    }

    public function destroy(int $series)
    {
        Series::destroy($series);

        return response()->noContent();
    }
}