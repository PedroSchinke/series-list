<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Repositories\UsersRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class UsersController extends Controller
{
    private UsersRepository $repository;

    public function __construct(UsersRepository $repository)
    {
        $this->repository = $repository;
    }

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

    public function favoriteSeries(int $seriesId)
    {
        $response = $this->repository->favoriteSeries($seriesId);

        return $response;
    }

    public function rateSeries(int $seriesId, Request $request)
    {
        $response = $this->repository->rateSeries($seriesId, $request);

        return $response;
    }
}
