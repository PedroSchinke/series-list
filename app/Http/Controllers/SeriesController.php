<?php

namespace App\Http\Controllers;

use App\Http\Requests\SeriesFormRequest;
use App\Models\Serie;
use Illuminate\Http\Request;

class SeriesController extends Controller
{
    public function index(Request $request) 
    {
        $series = Serie::all();
        // $series = Serie::query()->orderBy('name', 'desc')->get(); =>
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
        $serie = Serie::create($request->all()); // MASS ASSIGNMENT
        // SAME AS
        // $seriesName = $request->input('name'); // OR => $seriesName = $request->name;
        // $serie = new Serie();
        // $serie->name = $seriesName;
        // $serie->save();

        // FLASH MESSAGE
        // $request->session()->flash('message.success', "Series '{$serie->name}' added successfully!");
      
        return redirect()->route('series.index')
            ->with('message.success', "Series '{$serie->name}' added successfully!");
        // OR => return to_route('series.index'); Laravel ^9
        // OR => return redirect('/series');
    }

    public function destroy(Serie $series, Request $request)
    {
        //$serie = Serie::find($series);
        //Serie::destroy($request->serie);

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

    public function edit(Serie $series)
    {
        return view('series.edit')->with('serie', $series);
    }

    public function update(Serie $series, SeriesFormRequest $request)
    {
        $series->fill($request->all());
        // OR => $series->name = $request->name;

        $series->save();

        return redirect()->route('series.index')
            ->with('message.success', "Series '{$series->name}' updated successfully!");
    }
}
