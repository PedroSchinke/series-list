<?php

namespace App\Http\Controllers;

use App\Http\Requests\SeriesFormRequest;
use App\Mail\SeriesCreated;
use App\Models\Series;
use App\Models\User;
use App\Repositories\SeriesRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class SeriesController extends Controller
{
    private SeriesRepository $repository;

    public function __construct(SeriesRepository $repository)
    {
        $this->repository = $repository;
        $this->middleware('auth')->except('index');
    }

    public function index(Request $request) 
    {
        $series = Series::all();
        // $series = Series::query()->orderBy('name', 'desc')->get(); =>
        // => returns a more specific query, sorted in ascending alphabetical order 

        $successMessage = $request->session()->get('message.success');

        // $request->session()->forget('message.success');

        return view('series.index', [
            'seriesArray' => $series,
            'successMessage' => $successMessage
        ]);
        // OR => return view('series-list')->with('series', $series);
    }

    public function create()
    {
        return view('series.create');
    }

    public function store(SeriesFormRequest $request)
    {
        $series = $this->repository->add($request);

        $usersList = User::all();
        foreach ($usersList as $user) {
            $email = new SeriesCreated(
                $series->name,
                $series->id,
                $request->seasonsQty,
                $request->episodesPerSeason
            );
            Mail::to($request->user())->queue($email);
            // OR => Mail::to(Auth::user());
        }

        return redirect()->route('series.index')
            ->with('message.success', "Series '{$series->name}' added successfully!");
        // OR => return to_route('series.index'); Laravel ^9
        // OR => return redirect('/series');
    }

    public function destroy(Series $series, Request $request)
    {
        //$series = Series::find($series);
        //Series::destroy($request->series);

        $series->delete();

        // FLASH MESSAGE
        // $request->session()->flash('message.success', "Series '{$series->name}' removed successfully!");
        // OR => $request->session()->put('message.success', "Series '{$series->name}' removed successfully!"); NEEDS forget() in index() to flash message

        return redirect()->route('series.index')
            ->with('message.success', "Series '{$series->name}' removed successfully!");
        // OR => return to_route('series.index'); Laravel ^9
        // OR => return redirect('/series');

        // return redirect(route('series.index'))->with('message.success', "Series '{$series->name}' removed successfully!");
    }

    public function edit(Series $series)
    {
        return view('series.edit')->with('series', $series);
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
