<?php

namespace App\Http\Controllers\admin\Categorie;

use App\Http\Controllers\Controller;
use App\Http\Requests\CategoryRequest;
use App\Http\Resources\Category;
use App\Services\CategorieServices;
use Illuminate\Http\Request;

class CategorieController extends Controller
{
    protected $categoryService;

    public function __construct(CategorieServices $categoryService)
    {
        $this->categoryService = $categoryService;
    }

    public function index()
    {
        $categories = $this->categoryService->index();
        return response()->json(Category::collection($categories));
    }

    public function store(CategoryRequest $request)
    {
        $category = $this->categoryService->store($request);
        return response()->json(new Category($category), 201);
    }

    public function show($id)
    {
        $category = $this->categoryService->show($id);
        if (!$category) {
            return response()->json(['message' => 'Kategoriya topilmadi'], 404);
        }
        return response()->json(new Category($category));
    }

    public function update(CategoryRequest $request, $id)
    {
        $category = $this->categoryService->update($request, $id);
        if (!$category) {
            return response()->json(['message' => 'Kategoriya topilmadi'], 404);
        }
        return response()->json(['message' => 'O\'zgartirildi', 'category' => new Category($category)]);
    }

    public function destroy($id)
    {
        $deleted = $this->categoryService->destroy($id);
        if (!$deleted) {
            return response()->json(['message' => 'Kategoriya topilmadi'], 404);
        }
        return response()->json(['message' => 'Kategoriya o\'chirildi']);
    }
}
