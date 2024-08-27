<?php

namespace Database\Seeders;

use App\Models\Series;
use Illuminate\Database\Seeder;

class SeriesSeed extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Series::factory()
            ->withSeasonsAndEpisodes(1000, 5)
            ->create([
                'name' => 'Série',
            ]);
    }
}
