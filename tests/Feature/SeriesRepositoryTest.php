<?php

namespace Tests\Feature;

use App\Http\Requests\SeriesFormRequest;
use App\Models\Series;
use App\Repositories\SeriesRepository;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class SeriesRepositoryTest extends TestCase
{
    use RefreshDatabase;

    public function test_when_a_series_is_created_its_seasons_and_episodes_must_also_be_created()
    {
        /** NOT USING FACTORIES */
        // // ARRANGE
        // /** @var SeriesRepository $repository */
        // $repository = $this->app->make(SeriesRepository::class);
        // $request = new SeriesFormRequest();
        // $request->name = 'New test series';
        // $request->seasons_qty = 1;
        // $request->episodes_per_season = 1;

        // // ACT
        // $repository->add($request);

        // // ASSERT
        // $this->assertDatabaseHas('series', ['name' => 'New test series']);
        // $this->assertDatabaseHas('seasons', ['number' => 1]);
        // $this->assertDatabaseHas('episodes', ['number' => 1]);

        /** USING FACTORIES */
        // ARRANGE => States the series attributes values
        $seriesName = 'New test series';
        $seasonsCount = 5;
        $episodesPerSeason = 4;

        // ACT => Creates a series with the specified values
        Series::factory()
            ->withSeasonsAndEpisodes($seasonsCount, $episodesPerSeason)
            ->create([
                'name' => $seriesName,
            ]);

        // ASSERT
        // => Verify the series name
        $this->assertDatabaseHas('series', [
            'name' => 'New test series',
        ]);

        // => Verify the seasons count
        $this->assertDatabaseCount('seasons', 5);

        // => Verify the episodes count
        $this->assertDatabaseCount('episodes', 20); // 5 * 4 = 20
    }
}
