<?php

namespace App\Repositories;

use App\Http\Requests\SeriesFormRequest;
use App\Models\Episode;
use App\Models\Season;
use App\Models\Series;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class EloquentSeriesRepository implements SeriesRepository
{
    public function getAll(int $itemsPerPage, Request $request): LengthAwarePaginator
    {
        $query = Series::query();

        if ($name = $request->input('name')) {
            $query->where('name', 'ILIKE', '%' . $name . '%');
        }

        $series = $query->paginate($itemsPerPage);

        return $series;
    }

    public function add(SeriesFormRequest $request): Series
    {
        return DB::transaction(function () use ($request) {
            $series = Series::create([
                'name' => $request->input('name'),
                'cover' => $request->coverPath,
                'seasonsQty' => (int) $request->input('seasonsQty'),
                'episodesPerSeason' => (int) $request->input('episodesPerSeason')
            ]);

            /**
             * MASS ASSIGNMENT
             */
            // $series = Series::create($request->all())
            // SAME AS
            // $seriesName = $request->input('name'); // OR => $seriesName = $request->name;
            // $series = new Series();
            // $series->name = $seriesName;
            // $series->save();

            // FLASH MESSAGE
            // $request->session()->flash('message.success', "Series '{$series->name}' added successfully!");

            $seasons = [];
            for ($i = 1; $i <= $request->input('seasonsQty'); $i++) { 
                $seasons[] = [
                    'series_id' => $series->id,
                    'number' => $i,
                ];
            }
            Season::insert($seasons);

            $episodes = [];
            foreach ($series->seasons as $season) {
                for ($j = 1; $j <= $request->input('episodesPerSeason'); $j++) {
                    $episodes[] = [
                        'season_id' => $season->id,
                        'number' => $j,
                    ];
                } 
            }
            Episode::insert($episodes);

            $selectedCategories = $request->input('selected_categories', '');
            $categoryIds = explode(',', $selectedCategories);
            $series->categories()->sync($categoryIds);

            return $series;
        });
    }
}