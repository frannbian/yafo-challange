<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Services\CategoryService;
use App\Services\CMDBService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class CMDBController extends Controller
{

    protected CMDBService $cmdbService;
    protected CategoryService $categoryService;

    public function __construct(CMDBService $cmdbService, CategoryService $categoryService)
    {
        $this->cmdbService = $cmdbService;
        $this->categoryService = $categoryService;
    }

    public function index(Request $request): JsonResponse
    {
        $categoryId = $request->get('category_id');
        $cacheKey = md5('cmdb');
        $cmdb = Cache::tags(['cmdb'])->remember($cacheKey, 3600, function () use ($categoryId) {
            return $this->cmdbService->get($categoryId);
        });

        return response()->json($cmdb);
    }

    public function import()
    {
        return $this->cmdbService->importFromExcel();
    }

    public function export(Request $request)
    {
        $categoryId = $request->get('category_id');

        $cacheKey = md5('categories');
        $categories = Cache::tags(['categories'])->remember($cacheKey, 3600, function () {
            return $this->categoryService->get();
        });


        $cacheKey = md5('cmdb');
        $cmdb = Cache::tags(['cmdb'])->remember($cacheKey, 3600, function () use ($categoryId) {
            return $this->cmdbService->get($categoryId);
        });

        return $this->cmdbService->exportToExcel($cmdb);
    }
}
