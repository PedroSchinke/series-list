<?php

namespace App\Http\Controllers;

use App\Models\Series;
use Illuminate\Http\Request;

class SeasonsController extends Controller
{
    public function index(Series $series, Request $request)
    {
        // $seasons = $series->seasons()->with('episodes')->get();
        // // OR => $seasons = Season::query()->with('episodes')->where('series_id', $series)->get(); 
        // // NEEDS to receive int $series as a parameter

        // $successMessage = $request->session()->get('message.success'); // Catches flash message

        // $season = $seasons->where('number', 1)->first();
        // $episodes = $season->episodes;

        // return view('seasons.index', compact('seasons', 'series', 'successMessage', 'episodes'));

        $seasonNumber = $request->input('season');
    
        if ($request->ajax()) {
            $season = $series->seasons()->where('number', $seasonNumber)->first();
            if ($season) {
                $episodes = $season->episodes;
                return response()->json($episodes);
            }

            return response()->json(['message' => 'Season not found'], 404);
        }

        $seasons = $series->seasons()->with('episodes')->get();
        $successMessage = $request->session()->get('message.success');
        $season = $series->seasons()->where('number', 1)->first();
        $episodes = $season->episodes;

        return view('seasons.index', compact('seasons', 'series', 'successMessage', 'episodes'));
    }
}
