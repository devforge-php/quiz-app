<?php

namespace App\Services;

use App\Http\Requests\CategoryRequest;
use App\Http\Resources\Category;
use App\Models\Categorie;

class CategorieServices 
{
    public function index()
    {
        $category = Categorie::all();

        return response()->json(Category::collection($category));
    }

    public function store(CategoryRequest $request)
    {
   $category = Categorie::create($request->all());

    return response()->json(new Category($category));
    }
    public function show($id)
    {
        $category = Categorie::find($id);
        return response()->json(new Category($category));
    }
    public function update(CategoryRequest $request, $id)
    {
        $category = Categorie::find($id);
        if (!$category) {
            return response()->json(['message' => 'Kategoriya topilmadi'], 404);
        }

        $category->update($request->all());
        return response()->json(['message' => 'O\'zgartirildi']);
    }
    public function destroy($id)
    {
        $requestData = Categorie::find($id);

        $requestData->delete();
        return response()->json(['message' => 'ochirildi']);
        
    }


}



?>