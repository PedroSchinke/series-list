<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Series extends Model
{
    use HasFactory;
    protected $fillable = ['name', 'cover', 'seasons_qty', 'episodes_per_season', 'synopsis'];
    protected $with = ['seasons', 'categories']; // To not use lazy loading in seasons and categories
    protected $appends = ['links']; // Add links of getLinksAttribute() to JSON response

    public function seasons()
    {
        return $this->hasMany(Season::class, 'series_id');
    }

    public function episodes()
    {
        return $this->hasManyThrough(Episode::class, Season::class);
    }

    public function categories()
    {
        return $this->belongsToMany(Category::class, 'category_series');
    }

    public function favoritedBy()
    {
        return $this->belongsToMany(User::class, 'favorites');
    }

    public function ratings()
    {
        return $this->belongsToMany(User::class, 'series_user_ratings');
    }

    public function averageRating()
    {
        $average = $this->ratings()->avg('rating');

        return number_format((float)$average, 1, '.', '');
    }

    /**
     * Global scope
     * -> returns array sorted in ascending alphabetical order
     */
    protected static function booted()
    {
        self::addGlobalScope('ordered', function (Builder $queryBuilder) {
            $queryBuilder->orderBy('name');
        });
    }

    /**
     * Local scope example
     */
    // public function scopeActive(Builder $query)
    // {
    //     return $query->where('active', true);
    // }

    // Laravel ^9
    // public function links(): Attribute
    // {
    //     return new Atributte(
    //         get: fn () => [
    //             [
    //                 'rel' => 'self',
    //                 'url' => "/api/series/{$this->id}",
    //             ],
    //             [
    //                 'rel' => 'seasons',
    //                 'url' => "/api/series/{$this->id}/seasons",
    //             ],
    //             [
    //                 'rel' => 'episodes',
    //                 'url' => "/api/series/{$this->id}/episodes",
    //             ],
    //         ];
    //     );
    // }

    public function getLinksAttribute()
    {
        return [
            [
                'rel' => 'self',
                'url' => "/api/series/{$this->id}",
            ],
            [
                'rel' => 'seasons',
                'url' => "/api/series/{$this->id}/seasons",
            ],
            [
                'rel' => 'episodes',
                'url' => "/api/series/{$this->id}/episodes",
            ],
        ];
    }
}
