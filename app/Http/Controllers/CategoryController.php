<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreCategoryRequest;
use App\Http\Requests\UpdateCategoryRequest;
use App\Http\Resources\CategoryResource;
use App\Models\Category;
use App\Http\Controllers\MainController as MainController;

class CategoryController extends MainController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        try {
            $categories = Category::all();
            return $this->sendResponse(CategoryResource::collection($categories), 'Get all categories');
        } catch (\Exception $e) {
            return $this->sendError('error Exception:', $e->getMessage());
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreCategoryRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreCategoryRequest $request)
    {
        try {
            $categories = Category::create($request->all());
            return $this->sendResponse(new CategoryResource($categories), 'Create new category');
        } catch (\Exception $e) {
            return $this->sendError('error Exception:', $e->getMessage());
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateCategoryRequest  $request
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateCategoryRequest $request, Category $category)
    {
        try {
            $category->update($request->all());
            return $this->sendResponse(new CategoryResource($category), 'Update category');
        } catch (\Exception $e) {
            return $this->sendError('error Exception:', $e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function destroy(Category $category)
    {
        try {
            $category->delete();
            return $this->sendResponse([], 'Category deleted successfully');
        } catch (\Exception $e) {
            return $this->sendError('error Exception:', $e->getMessage());
        }
    }
}
