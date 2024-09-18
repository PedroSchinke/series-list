<?php

namespace App\Providers;

use App\Repositories\CategoriesRepository;
use App\Repositories\EloquentCategoriesRepository;
use App\Repositories\EloquentEpisodesRepository;
use App\Repositories\EloquentSeasonsRepository;
use App\Repositories\EloquentSeriesRepository;
use App\Repositories\EpisodesRepository;
use App\Repositories\SeasonsRepository;
use App\Repositories\SeriesRepository;
use Illuminate\Support\ServiceProvider;

class RepositoriesProvider extends ServiceProvider
{
    public array $bindings = [
        SeriesRepository::class => EloquentSeriesRepository::class,
        SeasonsRepository::class => EloquentSeasonsRepository::class,
        EpisodesRepository::class => EloquentEpisodesRepository::class,
        CategoriesRepository::class => EloquentCategoriesRepository::class
    ];

    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        // $this->app->bind(SeriesRepository::class, EloquentSeriesRepository::class);
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
