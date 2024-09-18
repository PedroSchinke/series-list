<?php

namespace App\Http\Controllers;

use App\Models\Season;
use App\Repositories\EpisodesRepository;
use Illuminate\Http\Request;

class EpisodesController extends Controller
{
    private EpisodesRepository $repository;

    public function __construct(EpisodesRepository $repository)
    {
        $this->repository = $repository;
    }

    public function index(Season $season, Request $request)
    {
        $episodes = $this->repository->get($season);

        if ($request->ajax()) {
            return response()->json($episodes);
        }

        return view('episodes.index', compact('episodes'));
    }

    public function update(Season $season, Request $request)
    {
        $this->repository->update($request, $season->id);

        // LESS PERFORMANT OPTION
        // $episodes = $season->episodes()->whereIn('id', $request->episodes)->get();
        // foreach ($episodes as $episode) {
        //     $episode->watched = true;
        //     $episode->save();
        // }

        return redirect()->route('seasons.index', ['series' => $season->series_id])
            ->with('message.success', "Episodes marked as watched successfully!");
    }
}
