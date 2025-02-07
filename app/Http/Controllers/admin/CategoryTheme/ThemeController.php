<?php

namespace App\Http\Controllers\admin\CategoryTheme;

use App\Http\Controllers\Controller;
use App\Http\Resources\ThemeCategory;
use App\Models\Theme;
use Illuminate\Http\Request;

class ThemeController extends Controller
{
   
    public function index()
    {
        $theme = Theme::paginate(10);
        return response()->json(ThemeCategory::collection($theme));
    }

    
    public function store(Request $request)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:30'],

        ]);
      $theme =  Theme::create($request->all());

        return response()->json(new ThemeCategory($theme));
    }

   

 
    public function update(Request $request, string $id)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:30'],

        ]);
        $requestData = Theme::find($id);

        $requestData->update($request->all());

        return response()->json(ThemeCategory::collection($requestData));
    }


    public function destroy(string $id)
    {
        $requestData = Theme::find($id);

        $requestData->delete();

        return response()->json(['message' => 'Category Ochirildi']);
    }
}
