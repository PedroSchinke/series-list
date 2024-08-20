<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Series extends Model
{
    use HasFactory;
    protected $fillable = ['name', 'cover'];
    protected $with = ['seasons']; // To not use lazy loading in seasons 

    public function seasons()
    {
        return $this->hasMany(Season::class, 'series_id');
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
}
