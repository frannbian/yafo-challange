<?php

namespace App\Services;

use App\Integrations\Aleph\Api\Aleph;
use Illuminate\Support\Collection;

class CategoryService
{
    /**
     * Create a new command instance.
     */
    public function __construct(
        public Aleph $api,
    ) {}

    public function get(): Collection
    {
        return $this->api
                ->getCategories();
    }

    public function getCMDBByCategory($categoryId): Collection
    {
        return $this->api
                ->getCMDB($categoryId);
    }
}
