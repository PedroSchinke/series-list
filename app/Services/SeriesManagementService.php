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
        });
    }

    public function updateSeriesAttributes(Series $series, SeriesFormRequest $request)
    {
        $selectedCategories = $request->input('selected_categories', '');
        $categoryIds = explode(',', $selectedCategories);
        $series->categories()->sync($categoryIds);
        
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
        if ($series->seasonsQty !== (int) $request->input('seasonsQty')) {
            $this->updateSeasonsQty($series, $request->input('seasonsQty'), $series->episodesPerSeason);
        }
        
        if ($series->episodesPerSeason !== (int) $request->input('episodesPerSeason')) {
            $this->updateEpisodesPerSeason($series, $series->episodesPerSeason, $request->input('episodesPerSeason'));
        }
    }

    public function updateSeasonsQty(Series $series, int $newSeasonsQty, int $episodesPerSeason)
    {
        if ($series->seasonsQty < $newSeasonsQty) {
            $this->seasonsRepository->increaseSeasons(
                $series, 
                $newSeasonsQty, 
                $episodesPerSeason
            );
        } elseif ($series->seasonsQty > $newSeasonsQty) {
            $this->seasonsRepository->decreaseSeasons($series, $series->seasonsQty, $newSeasonsQty);
        } 
    }

    public function updateEpisodesPerSeason(Series $series, int $episodesPerSeason, int $newEpisodesPerSeason)
    {
        if ($episodesPerSeason < $newEpisodesPerSeason) {
            $this->episodesRepository->increaseEpisodes(
                $series, 
                $episodesPerSeason, 
                $newEpisodesPerSeason
            );
        } elseif ($episodesPerSeason > $newEpisodesPerSeason) {
            $this->episodesRepository->decreaseEpisodes(
                $series, 
                $episodesPerSeason, 
                $newEpisodesPerSeason
            );
        }
    }
}