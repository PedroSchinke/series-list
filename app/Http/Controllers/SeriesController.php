<?php

namespace App\Http\Controllers;

use App\Events\SeriesCreated as EventSeriesCreated;
use App\Http\Requests\SeriesFormRequest;
use App\Models\Season;
use App\Models\Series;
use App\Repositories\SeriesRepository;
use App\Services\SeriesManagementService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SeriesController extends Controller
{
    private SeriesRepository $repository;
    private SeriesManagementService $seriesService;

    public function __construct(SeriesRepository $repository, SeriesManagementService $seriesService)
    {
        $this->repository = $repository;
        $this->seriesService = $seriesService;
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
        $cover = $request->hasFile('cover')
            ? $request->file('cover')->store('series_cover', 'public')
            : null;
        $request->merge(['coverPath' => $cover]);

        $series = $this->repository->add($request);

        // Calls the SeriesCreated event
        EventSeriesCreated::dispatch(
            $series->name,
            $series->id,
            $request->input('seasonsQty'),
            $request->input('episodesPerSeason'),
        );

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
        if ($series->name !== $request->input('name')) {
            $series->fill($request->all())->save();
            // OR => $series->name = $request->name;
        }

        DB::transaction(function () use ($series, $request) {
            $seasonsCount = $series->seasons->count();
            $episodesPerSeason = $series->episodes->count() / $series->seasons->count();
    
            if ($seasonsCount !== (int) $request->input('seasonsQty')) {
                $this->seriesService->updateSeasonsQty($series, $request->input('seasonsQty'), $episodesPerSeason);
            }

            $seasons = Season::where('series_id', $series->id)->get();
            $seasonsCount = $seasons->count();
            
            if ($series->episodes->count() / $seasonsCount !== (int) $request->input('episodesPerSeason')) {
                $this->seriesService->updateEpisodesPerSeason($series, $seasons, $episodesPerSeason, $request->input('episodesPerSeason'));
            }
        });

        return redirect()->route('series.index')
            ->with('message.success', "Series '{$series->name}' updated successfully!");
    }
}
