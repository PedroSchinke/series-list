<?php

namespace App\Repositories;

use Illuminate\Http\Request;

interface EpisodesRepository
{
    public function update(Request $request, int $seasonId);
}