<?php

namespace App\Repositories;

use App\Http\Requests\SeriesFormRequest;
use App\Models\Episode;
use App\Models\Season;
use App\Models\Series;
use Illuminate\Support\Facades\DB;

class EloquentSeriesRepository implements SeriesRepository
{
    public function add(SeriesFormRequest $request): Series
    {
        return DB::transaction(function () use ($request) {
            $series = Series::create([
                'name' => $request->input('name'),
                'cover' => $request->coverPath
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

            return $series;
        });
    }
}