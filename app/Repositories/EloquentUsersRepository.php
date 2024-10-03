<?php

namespace App\Repositories;

use App\Models\Series;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class EloquentUsersRepository implements UsersRepository
{
    public function favoriteSeries(int $seriesId)
    {
        /**
         * @var \App\Models\User &user
         */
        $user = Auth::user();

        if ($user->favoriteSeries()->where('series_id', $seriesId)->exists()) {
            $user->favoriteSeries()->detach($seriesId);
            return response()->json(['favorite' => false]);
        } else {
            $user->favoriteSeries()->attach($seriesId);
            return response()->json(['favorite' => true]);
        }
    }

    public function rateSeries(int $seriesId, Request $request)
    {
        /**
         * @var \App\Models\User &user
         */
        $user = Auth::user();

        $rating = $request->get('rate');

        $existingRating = $user->ratings()->where('series_id', $seriesId)->first();

        if ($existingRating) {
            if ($existingRating->pivot->rating == $rating) {
                $user->ratings()->detach($seriesId);
                return response()->json(['rating' => 0]);
            } else {
                $existingRating->pivot->rating = $rating;
                $existingRating->pivot->save();
            }
        } else {
            $user->ratings()->attach($seriesId, ['rating' => $rating]);
        }

        return response()->json(['rating' => $rating]);
    }

    public function getSeriesRating(int $seriesId)
    {
        /**
         * @var \App\Models\User &user
         */
        $user = Auth::user();

        $rating = $user->ratings()->where('series_id', $seriesId)->first()->pivot->rating ?? 0;

        return $rating;
    }
}
