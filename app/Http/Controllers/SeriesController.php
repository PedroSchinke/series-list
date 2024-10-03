<?php

namespace App\Http\Controllers;

use App\Events\SeriesCreated as EventSeriesCreated;
use App\Http\Requests\SeriesFormRequest;
use App\Models\Series;
use App\Repositories\CategoriesRepository;
use App\Repositories\SeriesRepository;
use App\Repositories\UsersRepository;
use App\Services\SeriesManagementService;
use Illuminate\Http\Request;

class SeriesController extends Controller
{
    private SeriesRepository $repository;
    private CategoriesRepository $categoriesRepository;
    private UsersRepository $usersRepository;
    private SeriesManagementService $seriesService;

    public function __construct(
        SeriesRepository $repository,
        CategoriesRepository $categoriesRepository,
        UsersRepository $usersRepository,
        SeriesManagementService $seriesService
    ) {
        $this->repository = $repository;
        $this->categoriesRepository = $categoriesRepository;
        $this->usersRepository = $usersRepository;
        $this->seriesService = $seriesService;
        $this->middleware('auth');
    }

    public function index(Request $request)
    {
        $series = $this->seriesService->getAllSeriesWithPagesData($request);

        $categories = $this->categoriesRepository->getAll();

        $successMessage = $request->session()->get('message.success');

        $isFavoritesSelected = $request->input('favorites') == 1;

        $requestCategories = $request->input('categories');

        // $request->session()->forget('message.success'); -> in case of $request->session->put()

        if ($request->ajax()) {
            return response()->json($series->withQueryString());
        }

        return view('series.index', [
            'title' => 'Series',
            'seriesArray' => $series->withQueryString(),
            'successMessage' => $successMessage,
            'name' => $request->input('name', ''),
            'isFavoritesSelected' => $isFavoritesSelected,
            'requestCategories' => $requestCategories,
            'categories' => $categories
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

        $season = $series->seasons()->where('number', 1)->first();
        $episodes = $season->episodes;

        $rating = $this->usersRepository->getSeriesRating($series->id);

        $successMessage = $request->session()->get('message.success');

        return view('series.show', compact('seasons', 'series', 'successMessage', 'episodes', 'rating'));
    }

    public function create()
    {
        $categories = $this->categoriesRepository->getAll();

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
            $request->input('seasons_qty'),
            $request->input('episodes_per_season'),
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
        $categories = $this->categoriesRepository->getAll();

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
