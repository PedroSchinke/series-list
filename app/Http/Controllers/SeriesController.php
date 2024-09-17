<?php

namespace App\Http\Controllers;

use App\Events\SeriesCreated as EventSeriesCreated;
use App\Http\Requests\SeriesFormRequest;
use App\Models\Category;
use App\Models\Series;
use App\Repositories\SeriesRepository;
use App\Services\SeriesManagementService;
use Illuminate\Http\Request;

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
        $series = $this->seriesService->getAllSeriesWithPagesData($request);

        $successMessage = $request->session()->get('message.success');

        // $request->session()->forget('message.success'); -> in case of $request->session->put()

        if ($request->ajax()) {
            return response()->json($series['series']->withQueryString());
        }

        return view('series.index', [
            'title' => 'Series',
            'seriesArray' => $series['series']->withQueryString(),
            'successMessage' => $successMessage,
            'nextPageUrl' => $series['nextPageUrl'],
            'previousPageUrl' => $series['previousPageUrl'],
            'lastPage' => $series['lastPage'],
            'currentPage' => $series['currentPage'],
            'name' => $request->input('name', '')
        ]);
        // OR => return view('series-list')->with('series', $series);
    }

    public function show(Series $series, Request $request) 
    {
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
        // OR => $seasons = Season::query()->with('episodes')->where('series_id', $series)->get(); 
        // NEEDS to receive int $series as a parameter
        
        $successMessage = $request->session()->get('message.success');
        $season = $series->seasons()->where('number', 1)->first();
        $episodes = $season->episodes;

        return view('series.show', compact('seasons', 'series', 'successMessage', 'episodes'));
    }

    public function create()
    {
        $categories = Category::all();

        return view('series.create', [
            'categories' => $categories
        ]);
    }

    public function store(SeriesFormRequest $request)
    {
        $series = $this->seriesService->storeSeries($request);

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
        $categories = Category::all();

        return view('series.edit', [
            'series' => $series,
            'categories' => $categories
        ]);
    }

    public function update(Series $series, SeriesFormRequest $request)
    {
        $this->seriesService->updateSeries($series, $request);

        return redirect()->route('series.index')
            ->with('message.success', "Series '{$series->name}' updated successfully!");
    }
}
