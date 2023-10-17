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

    private static function formatCategoryData(array $data): array
    {
        $data['name'] = ucwords(strtolower($data['name']));

        return $data;
    }

    public static function createCategory(array $data): Category
    {
        return Category::create(self::formatCategoryData($data));
    }

    public static function updateCategory(Category $category, array $data): Category
    {
        $category->update(self::formatCategoryData($data));

        return $category;
    }
}
