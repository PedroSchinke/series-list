<?php

namespace App\Repositories;

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
}