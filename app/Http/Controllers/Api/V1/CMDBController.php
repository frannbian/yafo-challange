<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\V1\ExportCMDBRequest;
use App\Services\CategoryService;
use App\Services\CMDBService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class CMDBController extends Controller
{

    protected CMDBService $cmdbService;

    public function __construct(CMDBService $cmdbService)
    {
        $this->cmdbService = $cmdbService;
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

    public function export(ExportCMDBRequest $request)
    {
        $categoryId = $request->get('category_id');
        $categoryInformation = $this->cmdbService->getCategoryInformation($categoryId);

        $cacheKey = md5("cmdb-{$categoryId}");
        $cmdb = Cache::tags(['cmdb'])->remember($cacheKey, 3600, function () use ($categoryId) {
            return $this->cmdbService->get($categoryId);
        });

        $fileName = $categoryInformation['name'] . '-' . date('d-m-Y', time());

        return $this->cmdbService->exportToExcel($cmdb, $categoryInformation['cmdb_fields'], $fileName);
    }
}
