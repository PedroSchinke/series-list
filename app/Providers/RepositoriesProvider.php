<?php

namespace App\Providers;

use App\Repositories\EloquentEpisodesRepository;
use App\Repositories\EloquentSeriesRepository;
use App\Repositories\EpisodesRepository;
use App\Repositories\SeriesRepository;
use Illuminate\Support\ServiceProvider;

class RepositoriesProvider extends ServiceProvider
{
    public array $bindings = [
        SeriesRepository::class => EloquentSeriesRepository::class,
        EpisodesRepository::class => EloquentEpisodesRepository::class,
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
