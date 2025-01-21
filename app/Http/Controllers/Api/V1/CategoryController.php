<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Services\CategoryService;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Cache;

class CategoryController extends Controller
{
    protected CategoryService $categoryService;

    public function __construct(CategoryService $categoryService)
    {
        $this->categoryService = $categoryService;
    }

    public function index(): JsonResponse
    {
        $cacheKey = md5('categories');
        $categories = Cache::tags(['categories'])->remember($cacheKey, 3600, function () {
            return $this->categoryService->get();
        });

        return response()->json($categories);
    }

    public function getCMDBByCategory(Int $categoryId): JsonResponse
    {
        $cacheKey = md5("cmdb-by-category-{$categoryId}");
        $cmdb = Cache::tags(['cmdb'])->remember($cacheKey, 3600, function () use ($categoryId) {
            return $this->categoryService->getCMDBByCategory($categoryId);
        });

        return response()->json($cmdb);
    }
}
