<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Season extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $with = ['episodes']; // To not use lazy loading in episodes
    protected $fillable = ['number'];

    public function series()
    {
        return $this->belongsTo(Series::class);
    }

    public function episodes()
    {
        return $this->hasMany(Episode::class);
    }

    public function numberOfWatchedEpisodes()
    {
        return $this->episodes
            ->filter(fn($episode) => $episode->watched)
            ->count();
    }
}
