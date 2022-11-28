<?php

namespace App\Http\Controllers;

use App\Http\Requests\CategoryRequest;
use App\Models\Category;
use App\Models\Product;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    /**
     * Display a listing of the parent Categories
     *
     */
    public function index(): JsonResponse
    {
        $list = Category::getCategories();
        return $this->successData($list);
    }

    /**
     * Display a listing of the resource.
     *
     */
    public function childCategories(Category $category): JsonResponse
    {
        $list = Category::getChildCategories($category);
        return $this->successData($list);
    }

    /**
     * Store a newly created resource in storage.
     *
     */
    public function store(CategoryRequest $categoryRequest): JsonResponse|Exception
    {
        try {
            Category::storeCategory($categoryRequest->only('name', 'parent_id'));
            return $this->success();
        } catch (Exception $exception) {
            return $exception;
        }
    }

    /**
     * Display the specified resource.
     *
     * @param Category $category
     * @return JsonResponse
     */
    public function show(Category $category): JsonResponse
    {
        return $this->successData($category->only('id', 'name', 'parent_id'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param CategoryRequest $categoryRequest
     * @param Category $category
     * @return Exception|JsonResponse
     */
    public function update(CategoryRequest $categoryRequest, Category $category): JsonResponse|Exception
    {
        try {
            Category::updateCategory($category ,$categoryRequest->only('name', 'parent_id'));
            return $this->success();
        } catch (Exception $exception) {
            return $exception;
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Category $category
     * @return JsonResponse|Exception
     */
    public function destroy(Category $category): JsonResponse|Exception
    {
        try {
            Category::deleteCategory($category);
            return $this->success();
        } catch (Exception $exception) {
            return $exception;
        }
    }
}
