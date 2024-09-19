<?php

namespace App\Repositories;

interface UsersRepository
{
    public function favoriteSeries(int $seriesId);
}