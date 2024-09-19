<?php

namespace App\Repositories;

use App\Http\Requests\SeriesFormRequest;
use App\Models\Episode;
use App\Models\Season;
use App\Models\Series;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class EloquentSeriesRepository implements SeriesRepository
{
    public function getAll(Request $request): LengthAwarePaginator
    {
        $query = Series::query();

        if ($name = $request->input('name')) {
            $query->where('name', 'ILIKE', '%' . $name . '%');
        }

        if ($request->input('favorites') == 1) {
            $query->whereHas('favoritedBy', function ($q) {
                $q->where('user_id', auth()->id());
            });
        }
    
        if ($request->filled('categories')) {
            $selectedCategories = $request->input('categories');
            $categoryIdsArray = explode(',', $selectedCategories);
    
            $query->whereHas('categories', function ($q) use ($categoryIdsArray) {
                $q->whereIn('categories.id', $categoryIdsArray);
            });
        }

        /**
         * @var \App\Models\User &user
         */
        $user = Auth::user();

        /**
         * @var \Illuminate\Contracts\Pagination\LengthAwarePaginator &series
         */
        $series = $query->paginate(4);

        if ($user) {
            $series->getCollection()->transform(function($series) use ($user) {
                $series->isFavorite = $user->favoriteSeries()->where('series_id', $series->id)->exists();
                return $series;
            });
        }

        return $series;
    }

    public function add(SeriesFormRequest $request): Series
    {
        return DB::transaction(function () use ($request) {
            $series = Series::create([
                'name' => $request->input('name'),
                'cover' => $request->coverPath,
                'seasons_qty' => (int) $request->input('seasons_qty'),
                'episodes_per_season' => (int) $request->input('episodes_per_season')
            ]);

            /**
             * MASS ASSIGNMENT
             */
            // $series = Series::create($request->all())
            // SAME AS
            // $seriesName = $request->input('name'); // OR => $seriesName = $request->name;
            // $series = new Series();
            // $series->name = $seriesName;
            // $series->save();

            // FLASH MESSAGE
            // $request->session()->flash('message.success', "Series '{$series->name}' added successfully!");

            $seasons = [];
            for ($i = 1; $i <= $request->input('seasons_qty'); $i++) { 
                $seasons[] = [
                    'series_id' => $series->id,
                    'number' => $i,
                ];
            }
            Season::insert($seasons);

            $episodes = [];
            foreach ($series->seasons as $season) {
                for ($j = 1; $j <= $request->input('episodes_per_season'); $j++) {
                    $episodes[] = [
                        'season_id' => $season->id,
                        'number' => $j,
                    ];
                } 
            }
            Episode::insert($episodes);

            $selectedCategories = $request->input('categories', '');
            $categoryIds = explode(',', $selectedCategories);
            $series->categories()->sync($categoryIds);

            return $series;
        });
    }

    public function updateCategories(Series $series, SeriesFormRequest $request)
    {
        $selectedCategories = $request->input('selected_categories', '');
        $categoryIds = explode(',', $selectedCategories);
        $series->categories()->sync($categoryIds);
    }
}