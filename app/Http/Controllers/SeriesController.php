<?php

namespace App\Http\Controllers;

use App\Http\Requests\SeriesFormRequest;
use App\Models\Episode;
use App\Models\Season;
use App\Models\Series;
use Illuminate\Http\Request;

class SeriesController extends Controller
{
    public function index(Request $request) 
    {
        $series = Series::all();
        // $series = Series::query()->orderBy('name', 'desc')->get(); =>
        // => returns a more specific query, sorted in ascending alphabetical order 

        $successMessage = $request->session()->get('message.success');

        // $request->session()->forget('message.success');

        return view('series.index', compact('series', 'successMessage'));
        // OR => return view('series-list')->with('series', $series);
    }

    public function create()
    {
        return view('series.create');
    }

    public function store(SeriesFormRequest $request)
    {
        $series = Series::create($request->all()); // MASS ASSIGNMENT
        // SAME AS
        // $seriesName = $request->input('name'); // OR => $seriesName = $request->name;
        // $serie = new Series();
        // $serie->name = $seriesName;
        // $serie->save();

        // FLASH MESSAGE
        // $request->session()->flash('message.success', "Series '{$serie->name}' added successfully!");

        $seasons = [];
        for ($i = 1; $i <= $request->seasonsQty; $i++) { 
            $seasons[] = [
                'series_id' => $series->id,
                'number' => $i,
            ];
        }
        Season::insert($seasons);

        $episodes = [];
        foreach ($series->seasons as $season) {
            for ($j = 1; $j <= $request->episodesPerSeason; $j++) {
                $episodes[] = [
                    'season_id' => $season->id,
                    'number' => $j,
                ];
            } 
        }
        Episode::insert($episodes);
      
        return redirect()->route('series.index')
            ->with('message.success', "Series '{$series->name}' added successfully!");
        // OR => return to_route('series.index'); Laravel ^9
        // OR => return redirect('/series');
    }

    public function destroy(Series $series, Request $request)
    {
        //$serie = Series::find($series);
        //Series::destroy($request->serie);

        $series->delete();

        // FLASH MESSAGE
        // $request->session()->flash('message.success', "Series '{$serie->name}' removed successfully!");
        // OR => $request->session()->put('message.success', "Series '{$serie->name}' removed successfully!"); NEEDS forget() in index() to flash message

        return redirect()->route('series.index')
            ->with('message.success', "Series '{$series->name}' removed successfully!");
        // OR => return to_route('series.index'); Laravel ^9
        // OR => return redirect('/series');

        // return redirect(route('series.index'))->with('message.success', "Series '{$series->name}' removed successfully!");
    }

    public function edit(Series $series)
    {
        return view('series.edit')->with('serie', $series);
    }

    public function update(Series $series, SeriesFormRequest $request)
    {
        $series->fill($request->all());
        // OR => $series->name = $request->name;

        $series->save();

        return redirect()->route('series.index')
            ->with('message.success', "Series '{$series->name}' updated successfully!");
    }
}
