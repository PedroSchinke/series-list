<?php

namespace App\Repositories;

use App\Models\Episode;
use App\Models\Season;
use Illuminate\Support\Facades\DB;

class EloquentSeasonsRepository implements SeasonsRepository
{
    public function increaseSeasons(int $seriesId, int $seasonsQty, int $newSeasonsQty, int $episodesPerSeason)
    {
        return DB::transaction(function () use ($seriesId, $seasonsQty, $newSeasonsQty, $episodesPerSeason) {
            $seasonsToAdd = [];
            for ($i = $seasonsQty +1; $i <= $newSeasonsQty; $i++) { 
                $seasonsToAdd[] = [
                    'series_id' => $seriesId,
                    'number' => $i,
                ];
            }
            Season::insert($seasonsToAdd);
    
            // Gets last inserted seasons
            $newSeasons = Season::where('series_id', $seriesId)
                ->whereBetween('number', [$seasonsQty + 1, $newSeasonsQty])
                ->orderBy('number', 'asc')
                ->get();

            // Inserts episodes in last inserted seasons
            $episodes = [];
            foreach ($newSeasons as $season) {
                for ($j = 1; $j <= $episodesPerSeason; $j++) {
                    $episodes[] = [
                        'season_id' => $season->id,
                        'number' => $j,
                    ];
                } 
            }
            Episode::insert($episodes);
        });
    }

    public function decreaseSeasons(int $seriesId, int $seasonsQty, int $newSeasonsQty)
    {
        $seasonsToDelete = [];
        for ($i = $seasonsQty; $i > $newSeasonsQty; $i--) { 
            $seasonsToDelete[] = $i;
        }
        
        Season::where('series_id', $seriesId)
            ->whereIn('number', $seasonsToDelete)
            ->delete();
    }
}