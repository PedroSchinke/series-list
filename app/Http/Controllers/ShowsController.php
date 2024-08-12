<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ShowsController extends Controller
{
    public function index(Request $request) 
    {
        $shows = [
            'The Boys',
            'Breaking Bad'
        ];

        return view('shows.index', compact('shows'));
        // OR => return view('shows-list')->with('shows', $shows);
    }

    public function create()
    {
        return view('shows.create');
    }
}
