<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class UsersController
{
    public function create()
    {
        return view('users.create');
    }

    public function store(Request $request)
    {
        $data = $request->except(['_token']);
        $data['password'] = Hash::make($data['password']);

        $user = User::create($data);
        Auth::login($user);

        return redirect()->route('series.index');
    }

    public function favoriteSeries($seriesId)
    {
        /**
         * @var \App\Models\User &user
         */
        $user = Auth::user();
        
        if ($user->favoriteSeries()->where('series_id', $seriesId)->exists()) {
            // Se já está favoritada, remove a série dos favoritos
            $user->favoriteSeries()->detach($seriesId);
            return response()->json(['favorite' => false]);
        } else {
            // Se não está favoritada, adiciona a série aos favoritos
            $user->favoriteSeries()->attach($seriesId);
            return response()->json(['favorite' => true]);
        }
    }
}