<?php

namespace App\Repositories;

use App\Http\Requests\SeriesFormRequest;
use App\Models\Episode;
use App\Models\Season;
use App\Models\Series;
use Illuminate\Support\Facades\DB;

class EloquentSeasonsRepository implements SeasonsRepository
{
    public function increaseSeasons(Series $series, SeriesFormRequest $request)
    {
        $newSeasonsQty = $request->input('seasons_qty');
        $episodes_per_season = $series->episodes_per_season;

        return DB::transaction(function () use ($series, $newSeasonsQty, $episodes_per_season) {
            $seasonsToAdd = [];
            for ($i = $series->seasons_qty +1; $i <= $newSeasonsQty; $i++) { 
                $seasonsToAdd[] = [
                    'series_id' => $series->id,
                    'number' => $i,
                ];
            }
            Season::insert($seasonsToAdd);
    
            // Gets last inserted seasons
            $newSeasons = Season::where('series_id', $series->id)
                ->whereBetween('number', [$series->seasons_qty + 1, $newSeasonsQty])
                ->orderBy('number', 'asc')
                ->get();

            // Inserts episodes in last inserted seasons
            $episodes = [];
            foreach ($newSeasons as $season) {
                for ($j = 1; $j <= $episodes_per_season; $j++) {
                    $episodes[] = [
                        'season_id' => $season->id,
                        'number' => $j,
                    ];
                } 
            }
            Episode::insert($episodes);

            $series->update([
                'seasons_qty' => $newSeasonsQty
            ]);
        });
    }

    public function decreaseSeasons(Series $series, SeriesFormRequest $request)
    {
        $newSeasonsQty = $request->input('seasons_qty');

        $seasonsToDelete = [];
        for ($i = $series->seasons_qty; $i > $newSeasonsQty; $i--) { 
            $seasonsToDelete[] = $i;
        }
        
        Season::where('series_id', $series->id)
            ->whereIn('number', $seasonsToDelete)
            ->delete();

        $series->update([
            'seasons_qty' => $newSeasonsQty
        ]);
    }
}