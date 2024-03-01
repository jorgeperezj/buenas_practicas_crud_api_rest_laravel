<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Resources\CategoryResource;
use App\Http\Resources\CategoryCollection;
use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function index()
    {
        return new CategoryCollection(Category::all());
    }

    public function show(Category $category)
    {
        // with, load
        $category = $category->load('recipes.category', 'recipes.tags', 'recipes.user');
        return new CategoryResource($category);
    }
}