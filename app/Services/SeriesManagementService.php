<?php

namespace App\Services;

use App\Models\Season;
use App\Models\Series;
use App\Repositories\EpisodesRepository;
use App\Repositories\SeasonsRepository;
use App\Repositories\SeriesRepository;
use Illuminate\Database\Eloquent\Collection;

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