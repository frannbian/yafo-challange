<?php

namespace App\Http\Controllers\Web\V1;

use App\Http\Controllers\Controller;
use App\Services\CategoryService;
use App\Services\CMDBService;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class CMDBController extends Controller
{
    public function __construct(
        public CMDBService $cmdbService,
        public CategoryService $categoryService
    )
    { }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): View
    {
        $categoryId = $request->get('category_id');
        $cmdb = Cache::tags(['cmdb'])->remember("cmdb-list-{$categoryId }", 3600, function () use ($categoryId) {
            return $this->cmdbService->get($categoryId);
        });

        $categories = Cache::tags(['category'])->remember('category-list', 3600, function () use ($request){
            return $this->categoryService->get();
        });

        return view('cmdb.list', compact('cmdb'), compact('categories'));
    }

    public function import()
    {
        $this->cmdbService->importFromExcel();
        return back();
    }

    public function export(Request $request)
    {
        $categoryId = $request->get('category_id');
        $categoryInformation = $this->cmdbService->getCategoryInformation($categoryId);

        $cacheKey = md5("cmdb-{$categoryId}");
        $cmdbs = Cache::tags(['cmdb'])->remember($cacheKey, 3600, function () use ($categoryId) {
            return $this->cmdbService->get($categoryId);
        });

        $fileName = $categoryInformation['name'] . '-' . date('d-m-Y', time());

        $data = [];
        foreach($cmdbs as $cmdb) {
            $parsedCmdb = [
                'identificator' => $cmdb->identificator,
                'name' => $cmdb->name,
                'category_id' => $cmdb->category_id,
            ];

            foreach($categoryInformation['cmdb_fields'] as $optionalField) {
                if(!empty($cmdb->optionalFields[iconv('UTF-8', 'ASCII//TRANSLIT', str($optionalField)->lower()->snake())])) {
                    $parsedCmdb[iconv('UTF-8', 'ASCII//TRANSLIT', str($optionalField)->lower()->snake())] = $cmdb->optionalFields[iconv('UTF-8', 'ASCII//TRANSLIT', str($optionalField)->lower()->snake())];
                }
            }
            $data[] = $parsedCmdb;
        }

        $data = collect($data);

        $this->cmdbService->exportToExcel($data, $categoryInformation['cmdb_fields'], $fileName);
        return back();
    }
}
