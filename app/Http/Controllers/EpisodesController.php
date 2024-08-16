<?php

namespace App\Http\Controllers;

use App\Models\Season;
use Illuminate\Http\Request;

class EpisodesController extends Controller
{
    public function index(Season $season)
    {
        $episodes = $season->episodes;

        return view('episodes.index', compact('episodes', 'season'));
    }
}
