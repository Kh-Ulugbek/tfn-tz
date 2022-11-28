<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProductRequest;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Exception;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     */
    public function index(): JsonResponse
    {
        $list = Product::getProducts();
        return $this->successData($list);
    }

    /**
     * Display a listing of the products by category.
     *
     */
    public function productsByCategory(Category $category): JsonResponse
    {
        $list = Product::getProductsByCategory();
        return $this->successData($list);
    }

    /**
     * Store a newly created resource in storage.
     *
     */
    public function store(ProductRequest $productRequest): JsonResponse|Exception
    {
        try {
            Product::storeProduct($productRequest->only('name', 'category_id'));
            return $this->success();
        } catch (Exception $exception) {
            return $exception;
        }
    }

    /**
     * Display the specified resource.
     *
     */
    public function show(Product $product): JsonResponse
    {
        return $this->successData($product->only('id', 'name', 'category_id'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param ProductRequest $productRequest
     * @param Product $product
     * @return Exception|JsonResponse
     */
    public function update(ProductRequest $productRequest, Product $product): JsonResponse|Exception
    {
        try {
            Product::updateProduct($product, $productRequest->only('name', 'category_id'));
            return $this->success();
        } catch (Exception $exception) {
            return $exception;
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     */
    public function destroy(Product $product): JsonResponse|Exception
    {
        try {
            Product::deleteProduct($product);
            return $this->success();
        } catch (Exception $exception) {
            return $exception;
        }
    }
}
