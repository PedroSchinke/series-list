<?php

namespace App\Repositories;

use App\Http\Requests\SeriesFormRequest;
use App\Models\Episode;
use App\Models\Season;
use App\Models\Series;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class EloquentEpisodesRepository implements EpisodesRepository
{
    public function get(Season $season)
    {
        $episodes = Episode::where('season_id', $season->id)->get();

        return $episodes;
    }

    public function update(Request $request, int $seasonId)
    {
        DB::transaction(function () use($request, $seasonId) {
            // Catches the ID's of the episodes that the client marked as 'watched'
            $watchedEpisodes = $request->input('episodes', []);

            // Mark the episodes as 'watched'
            DB::table('episodes')
                ->where('season_id', $seasonId)
                ->whereIn('id', $watchedEpisodes)
                ->update(['watched' => true]);

            // Unmark the episodes as 'watched'
            DB::table('episodes')
                ->where('season_id', $seasonId)
                ->whereNotIn('id', $watchedEpisodes)
                ->update(['watched' => false]);
        });
    }

    public function increaseEpisodes(Series $series, SeriesFormRequest $request)
    {
        $seasons = $series->seasons()->get();
        $newEpisodesPerSeason = $request->input('episodes_per_season');

        $episodes = [];
        foreach ($seasons as $season) {
            for ($i = $series->episodes_per_season + 1; $i <= $newEpisodesPerSeason; $i++) {
                $episodes[] = [
                    'season_id' => $season->id,
                    'number' => $i,
                ];
            } 
        }
        Episode::insert($episodes);

        $series->update([
            'episodes_per_season' => $newEpisodesPerSeason
        ]);
    }

    public function decreaseEpisodes(Series $series, SeriesFormRequest $request)
    {
        $newEpisodesPerSeason = $request->input('episodes_per_season');

        $episodesToDelete = [];
        for ($i = $series->episodes_per_season; $i > $newEpisodesPerSeason; $i--) { 
            $episodesToDelete[] = $i;
        }

        $seasonsIds = $series->seasons()->pluck('id')->toArray();

        Episode::whereIn('season_id', $seasonsIds)
            ->whereIn('number', $episodesToDelete)
            ->delete();

        $series->update([
            'episodes_per_season' => $newEpisodesPerSeason
        ]);
    }
}