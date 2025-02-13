<?php

namespace App\Http\Controllers\admin\Categorie;

use App\Http\Controllers\Controller;
use App\Http\Requests\CategoryRequest;
use App\Services\CategorieServices;
use Illuminate\Http\Request;

class CategorieController extends Controller
{
  public $categoryservices;
  public function __construct(CategorieServices $categoryservices)
  {
    $this->categoryservices = $categoryservices;
  }
    public function index()
    {
     return $this->categoryservices->index();
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CategoryRequest $request)
    {
        return $this->categoryservices->store($request);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        return $this->categoryservices->show($id);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(CategoryRequest $request, string $id)
    {
        return $this->categoryservices->update($request, $id);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        return $this->categoryservices->destroy($id);
    }
}
