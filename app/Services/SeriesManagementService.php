<?php

namespace App\Services;

use App\Http\Requests\SeriesFormRequest;
use App\Models\Season;
use App\Models\Series;
use App\Repositories\EpisodesRepository;
use App\Repositories\SeasonsRepository;
use App\Repositories\SeriesRepository;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\DB;

class SeriesManagementService
{
    private SeriesRepository $seriesRepository;
    private SeasonsRepository $seasonsRepository;
    private EpisodesRepository $episodesRepository;

    public function __construct(
        SeriesRepository $seriesRepository,
        SeasonsRepository $seasonsRepository,
        EpisodesRepository $episodesRepository
    )
    {
        $this->seriesRepository = $seriesRepository;
        $this->seasonsRepository = $seasonsRepository;
        $this->episodesRepository = $episodesRepository;
    }

    public function updateSeries(Series $series, SeriesFormRequest $request)
    {
        DB::transaction(function () use ($series, $request) {
            $this->updateSeriesAttributes($series, $request);
            $this->handleSeasonsAndEpisodes($series, $request);
        });
    }

    public function updateSeriesAttributes(Series $series, SeriesFormRequest $request)
    {
        if ($series->name !== $request->input('name') || $request->hasFile('cover')) {
            if ($request->hasFile('cover')) {
                $cover = $request->file('cover')->store('series_cover', 'public');
                $request->merge(['coverPath' => 'storage/' . $cover]);
            } else {
                $request->merge(['coverPath' => $series->cover]);
            }

            $series->update([
                'name' => $request->input('name'),
                'cover' => $request->coverPath
            ]);
            //$series->fill($request->all())->save();
            // OR => $series->name = $request->name;
        }
    }

    public function handleSeasonsAndEpisodes(Series $series, SeriesFormRequest $request)
    {
        $seasonsCount = $series->seasons->count();
        $episodesPerSeason = $series->episodes->count() / $series->seasons->count();

        if ($seasonsCount !== (int) $request->input('seasonsQty')) {
            $this->updateSeasonsQty($series, $request->input('seasonsQty'), $episodesPerSeason);
        }

        $seasons = Season::where('series_id', $series->id)->get();
        $seasonsCount = $seasons->count();
        
        if ($series->episodes->count() / $seasonsCount !== (int) $request->input('episodesPerSeason')) {
            $this->updateEpisodesPerSeason($series, $seasons, $episodesPerSeason, $request->input('episodesPerSeason'));
        }
    }

    public function updateSeasonsQty(Series $series, int $newSeasonsQty, int $episodesPerSeason)
    {
        $seasonsQty = $series->seasons->count();

        if ($seasonsQty < $newSeasonsQty) {
            $this->seasonsRepository->increaseSeasons(
                $series->id, 
                $seasonsQty, 
                $newSeasonsQty, 
                $episodesPerSeason
            );
        } elseif ($seasonsQty > $newSeasonsQty) {
            $this->seasonsRepository->decreaseSeasons($series->id, $seasonsQty, $newSeasonsQty);
        } else {
            return null;
        }
    }

    public function updateEpisodesPerSeason(Series $series, Collection $seasons, int $episodesPerSeason, int $newEpisodesPerSeason)
    {
        if ($episodesPerSeason < $newEpisodesPerSeason) {
            $this->episodesRepository->increaseEpisodes(
                $series->id, 
                $seasons, 
                $episodesPerSeason, 
                $newEpisodesPerSeason
            );
        } elseif ($episodesPerSeason > $newEpisodesPerSeason) {
            $this->episodesRepository->decreaseEpisodes(
                $series->id, 
                $seasons, 
                $episodesPerSeason, 
                $newEpisodesPerSeason
            );
        } else {
            return null;
        }
    }
}