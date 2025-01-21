<?php

namespace App\Services;

use App\Exports\CMDBExport;
use App\Http\Resources\Api\V1\CMDBResource;
use App\Imports\CMDBImport;
use App\Integrations\Aleph\Api\Aleph;
use App\Models\CMDB;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Cache;
use Maatwebsite\Excel\Facades\Excel;
use Symfony\Component\HttpFoundation\BinaryFileResponse;

class CMDBService
{
    /**
     * Create a new command instance.
     */
    public function __construct(
        public Aleph $api,
        public CategoryService $categoryService
    ) {}

    public function get(?int $categoryId = null): Collection
    {
        return $this->api
                ->getCMDB($categoryId);
    }

    public function getCategoryInformation(?int $categoryId = null): array
    {
        $cacheKey = md5('categories');
        $categories = Cache::tags(['categories'])->remember($cacheKey, 3600, function () {
            return $this->categoryService->get();
        });

        $category = $categories->firstWhere('id', $categoryId);

        return [
            'name' => $category->name,
            'cmdb_fields' => $category->cmdb_fields
        ];
    }

    /**
     * Get categories from database
     */
    public function exportToExcel(Collection $cmdb, array $headers, string $fileName): void
    {
        Excel::store(new CMDBExport($cmdb, $headers), "{$fileName}.xlsx");
    }

    /**
     * Get categories from database
     */
    public function importFromExcel(): void
    {
        Excel::import(new CMDBImport, request()->file('file'));
    }
}
