<?php

namespace App\Http\Controllers;

use App\Models\Season;
use Illuminate\Http\Request;

class EpisodesController extends Controller
{
    public function index(Season $season)
    {
        $episodes = $season->episodes;
        $series = $season->series;

        return view('episodes.index', compact('episodes', 'season', 'series'));
    }

    public function update(Season $season, Request $request)
    {
        $episodes = $season->episodes()->whereIn('id', $request->episodes)->get();

        foreach ($episodes as $episode) {
            $episode->watched = true;
            $episode->save();
        }

        return redirect()->route('seasons.index', ['series' => $season->series_id])
            ->with('message.success', "Episodes marked as watched successfully!");
    }
}
