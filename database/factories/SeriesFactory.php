<?php

namespace Database\Factories;

use App\Models\Episode;
use App\Models\Season;
use App\Models\Series;
use Illuminate\Database\Eloquent\Factories\Factory;

class SeriesFactory extends Factory
{
    protected $model = Series::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'name' => $this->faker->word,
            'cover' => $this->faker->imageUrl(),
        ];
    }

    public function withSeasonsAndEpisodes($seasons_qty, $episodes_per_season)
    {
        return $this->afterCreating(function (Series $series) use ($seasons_qty, $episodes_per_season) {
            $seasons = Season::factory()->count($seasons_qty)->make();
            
            foreach ($seasons as $index => $season) {
                $season->number = $index + 1; // Defines the season number
                $season->series_id = $series->id;
                $season->save();
                
                $episodes = Episode::factory()
                    ->count($episodes_per_season)
                    ->make()
                    ->each(function ($episode, $episodeIndex) use ($season) {
                        $episode->number = $episodeIndex + 1; // Defines the episode number
                        $episode->season_id = $season->id;
                    });

                $season->episodes()->saveMany($episodes);
            }
        });
    }
}
