<?php

namespace App\Http\Controllers;

use App\Models\Series;

class SeasonsController extends Controller
{
    public function index(Series $series)
    {
        $seasons = $series->seasons()->with('episodes')->get();
        // OR => $seasons = Season::query()->with('episodes')->where('series_id', $series)->get(); 
        // NEEDS to receive int $series as a parameter

        return view('seasons.index', compact('seasons', 'series'));
    }
}
