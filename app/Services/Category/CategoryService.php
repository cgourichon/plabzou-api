<?php

namespace App\Services\Category;

use App\Models\Category;
use Illuminate\Support\Collection;

class CategoryService
{
    public static function getCategories(): Collection
    {
        return Category::all();
    }

    public static function createCategory(array $data): Category
    {
        return Category::create($data);
    }

    public static function updateCategory(Category $category, array $data): Category
    {
        $category->update($data);

        return $category;
    }
}
