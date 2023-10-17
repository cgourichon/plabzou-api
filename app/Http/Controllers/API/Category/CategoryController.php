<?php

namespace App\Http\Controllers\API\Category;

use App\Http\Controllers\API\BaseController;
use App\Http\Requests\API\Course\CourseRequest;
use App\Models\Category;
use App\Services\Category\CategoryService;

class CategoryController extends BaseController
{
    public function index()
    {
        $categories = CategoryService::getCategories();

        return $this->success($categories->toArray(), 'Catégories récupérées avec succès.');
    }

    public function store(CourseRequest $request)
    {
        $category = CategoryService::createCategory($request->validated());

        return $this->success($category->toArray(), 'Catégorie créée avec succès.');
    }

    public function show(Category $category)
    {
        return $this->success($category->toArray(), 'Catégorie récupérée avec succès.');
    }

    public function update(CourseRequest $request, Category $category)
    {
        $category = CategoryService::updateCategory($category, $request->validated());

        return $this->success($category->toArray(), 'Catégorie mise à jour avec succès.');
    }

    public function destroy(Category $category)
    {
        $category->delete();

        return $this->success([], 'Catégorie supprimée avec succès.');
    }
}
