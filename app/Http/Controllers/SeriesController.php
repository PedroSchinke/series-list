<?php

namespace App\Http\Controllers;

use App\Events\SeriesCreated as EventSeriesCreated;
use App\Http\Requests\SeriesFormRequest;
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
        $series = $this->seriesService->getAllSeriesWithPagesData();

        $successMessage = $request->session()->get('message.success');

        // $request->session()->forget('message.success'); -> in case of $request->session->put()

        return view('series.index', [
            'title' => 'Series',
            'seriesArray' => $series['series'],
            'successMessage' => $successMessage,
            'nextPageUrl' => $series['nextPageUrl'],
            'previousPageUrl' => $series['previousPageUrl'],
            'lastPage' => $series['lastPage'],
            'currentPage' => $series['currentPage']
        ]);
        // OR => return view('series-list')->with('series', $series);
    }

    public function create()
    {
        return view('series.create');
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
        return view('series.edit', [
            'series' => $series
        ]);
    }

    public function update(Series $series, SeriesFormRequest $request)
    {
        $this->seriesService->updateSeries($series, $request);

        return redirect()->route('series.index')
            ->with('message.success', "Series '{$series->name}' updated successfully!");
    }
}
