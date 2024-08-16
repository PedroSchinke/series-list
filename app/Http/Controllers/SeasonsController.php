<?php

namespace App\Http\Controllers;

use App\Models\Series;
use Illuminate\Http\Request;

class SeasonsController extends Controller
{
    public function index(Series $series, Request $request)
    {
        $seasons = $series->seasons()->with('episodes')->get();
        // OR => $seasons = Season::query()->with('episodes')->where('series_id', $series)->get(); 
        // NEEDS to receive int $series as a parameter

        $successMessage = $request->session()->get('message.success'); // Catches flash message

        return view('seasons.index', compact('seasons', 'series', 'successMessage'));
    }
}
