<?php

namespace App\Services;

use App\Http\Requests\CategoryRequest;
use App\Models\Categorie;

class CategorieServices 
{
    public function index()
    {
        return Categorie::all();
    }

    public function store(CategoryRequest $request)
    {
        return Categorie::create($request->validated());
    }

    public function show($id)
    {
        return Categorie::find($id);
    }

    public function update(CategoryRequest $request, $id)
    {
        $category = Categorie::find($id);
        if (!$category) {
            return null;
        }

        $category->update($request->validated());
        return $category;
    }

    public function destroy($id)
    {
        $category = Categorie::find($id);
        if (!$category) {
            return false;
        }

        $category->delete();
        return true;
    }
}
