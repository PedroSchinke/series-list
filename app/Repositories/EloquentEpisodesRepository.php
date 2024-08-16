<?php

namespace App\Repositories;

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
}