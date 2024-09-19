<?php

namespace App\Services;

use App\Http\Requests\SeriesFormRequest;
use App\Models\Series;
use App\Repositories\EpisodesRepository;
use App\Repositories\SeasonsRepository;
use App\Repositories\SeriesRepository;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
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

    public function getAllSeriesWithPagesData(Request $request): LengthAwarePaginator
    {
        $series = $this->seriesRepository->getAll($request);

        return $series;
    }

    public function storeSeries(SeriesFormRequest $request): Series
    {
        $cover = $request->hasFile('cover')
            ? $request->file('cover')->store('series_cover', 'public')
            : 'images/default_image.jpg';
        if ($cover === 'images/default_image.jpg') {
            $request->merge(['coverPath' => $cover]);
        } else {
            $request->merge(['coverPath' => 'storage/' . $cover]);
        }

        $series = $this->seriesRepository->add($request);

        return $series;
    }

    public function updateSeries(Series $series, SeriesFormRequest $request)
    {
        DB::transaction(function () use ($series, $request) {
            $this->updateSeriesAttributes($series, $request);
            $this->handleSeasonsAndEpisodes($series, $request);
            $this->seriesRepository->updateCategories($series, $request);
        });
    }

    public function updateSeriesAttributes(Series $series, SeriesFormRequest $request)
    {
        if ($request->hasFile('cover')) {
            $cover = $request->file('cover')->store('series_cover', 'public');
            $request->merge(['coverPath' => 'storage/' . $cover]);
        } else {
            $request->merge(['coverPath' => $series->cover]);
        }

        $series->update([
            'name' => $request->input('name'),
            'cover' => $request->coverPath,
            'synopsis' => $request->input('synopsis')
        ]);
        //$series->fill($request->all())->save();
        // OR => $series->name = $request->name;
    }

    public function handleSeasonsAndEpisodes(Series $series, SeriesFormRequest $request)
    {
        if ($series->seasons_qty !== (int) $request->input('seasons_qty')) {
            $this->updateSeasonsQty($series, $request);
        }
        
        if ($series->episodes_per_season !== (int) $request->input('episodes_per_season')) {
            $this->updateEpisodesPerSeason($series, $series->episodes_per_season, $request->input('episodes_per_season'));
        }
    }

    public function updateSeasonsQty(Series $series, SeriesFormRequest $request)
    {
        if ($series->seasons_qty < $request->input('seasons_qty')) {
            $this->seasonsRepository->increaseSeasons($series, $request);
        } elseif ($series->seasons_qty > $request->input('seasons_qty')) {
            $this->seasonsRepository->decreaseSeasons($series, $request);
        } 
    }

    public function updateEpisodesPerSeason(Series $series, int $episodes_per_season, int $newEpisodesPerSeason)
    {
        if ($episodes_per_season < $newEpisodesPerSeason) {
            $this->episodesRepository->increaseEpisodes(
                $series, 
                $episodes_per_season, 
                $newEpisodesPerSeason
            );
        } elseif ($episodes_per_season > $newEpisodesPerSeason) {
            $this->episodesRepository->decreaseEpisodes(
                $series, 
                $episodes_per_season, 
                $newEpisodesPerSeason
            );
        }
    }
}