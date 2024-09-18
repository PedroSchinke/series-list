<?php

namespace App\Repositories;

use App\Models\Category;

class EloquentCategoriesRepository implements CategoriesRepository
{
    public function getAll()
    {
        $categories = Category::all();

        return $categories;
    }
}