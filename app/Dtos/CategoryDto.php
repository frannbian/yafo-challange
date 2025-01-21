<?php

namespace App\Dtos;

class CategoryDto
{
    /**
     * Construct
     *
     * @return void
     */
    public function __construct(
        public int $id,
        public string $name,
        public array $cmdb_fields,
    ) {
        //
    }
}
