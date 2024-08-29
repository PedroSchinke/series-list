<?php

namespace App\Repositories;

use App\Models\Episode;
use App\Models\Series;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class EloquentEpisodesRepository implements EpisodesRepository
{
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

    public function increaseEpisodes(Series $series, int $episodesPerSeason, int $newEpisodesPerSeason)
    {
        $seasons = $series->seasons()->get();

        $episodes = [];
        foreach ($seasons as $season) {
            for ($i = $episodesPerSeason + 1; $i <= $newEpisodesPerSeason; $i++) {
                $episodes[] = [
                    'season_id' => $season->id,
                    'number' => $i,
                ];
            } 
        }
        Episode::insert($episodes);

        $series->update([
            'episodesPerSeason' => $newEpisodesPerSeason
        ]);
    }

    public function decreaseEpisodes(Series $series, int $episodesPerSeason, int $newEpisodesPerSeason)
    {
        $episodesToDelete = [];
        for ($i = $episodesPerSeason; $i > $newEpisodesPerSeason; $i--) { 
            $episodesToDelete[] = $i;
        }

        $seasonsIds = $series->seasons->pluck('id')->toArray();

        Episode::whereIn('season_id', $seasonsIds)
            ->whereIn('number', $episodesToDelete)
            ->delete();

        $series->update([
            'episodesPerSeason' => $newEpisodesPerSeason
        ]);
    }
}